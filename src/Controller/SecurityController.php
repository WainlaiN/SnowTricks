<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Services\UploadHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    /**
     * @Route("/registration", name="security_registration")
     *
     */
    public function registration(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder,
        UploadHelper $uploadHelper,
        \Swift_Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //hash and set password to user
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            //generate Activation Token
            $user->setActivationToken($tokenGenerator->generateToken());

            //get Picture in form
            $pictureFile = $user->getFile();

            //save MainImage in directory
            $PictureImage = $uploadHelper->savePicture($pictureFile);

            //set Picture to User
            $user->setPhoto($PictureImage);

            $manager->persist($user);
            $manager->flush();

            //Send email
            $message = (new \Swift_Message('Activation de votre compte'))
                ->setFrom("nicodupblog@gmail.com")
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/activation.html.twig',
                        ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash(
                'success',
                'Votre compte a été enregistré !'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'security/registration.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/login", name="security_login")
     *
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {

        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }

    /**
     * @Route("/logout", name="security_logout")
     *
     */
    public function logout()
    {

    }

    /**
     * @Route("/activate/{token}", name="security_activate")
     *
     */
    public function activate($token, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $user = $userRepository->findOneBy(['activationToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        $user->setActivationToken(null);
        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre compte a été activé !'
        );

        return $this->redirectToRoute('trick');


    }

    /**
     * @Route("/reset", name="security_forgotten_password")
     *
     */
    public function forgottenPassword(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        \Swift_Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepository->findOneBy(['email' => $data['email']]);

            if (!$user) {
                $this->addFlash(
                    'danger',
                    'Cet email n\'existe pas!'
                );

                $this->redirectToRoute('security_login');
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }


        }
    }
}
