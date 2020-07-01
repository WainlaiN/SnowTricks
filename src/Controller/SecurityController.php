<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Services\UploadHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
        MailerInterface $mailer,
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
            $message = (new Email())
                ->subject('Activation de votre compte!')
                ->from("nicodupblog@gmail.com")
                ->to($user->getEmail())
                ->html(
                    $this->renderView(
                        'email/activation.html.twig',
                        ['token' => $user->getActivationToken()]
                    )
                );
            $mailer->send($message);

            $this->addFlash(
                'success',
                'Votre compte a été enregistré, vérifiez vos emails pour l\'activation !'
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

        return $this->redirectToRoute('security_login');

    }

    /**
     * @Route("/forgotten-password", name="security_forgotten_password")
     *
     */
    public function forgottenPassword(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->get('email')->getData();

            $user = $userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash(
                    'danger',
                    'Cet email n\'existe pas!'
                );

                return $this->redirectToRoute('security_login');
            }

            $token = $tokenGenerator->generateToken();

            try {
                $user->setResetToken($token);
                $manager->persist($user);
                $manager->flush();
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue :' / $e->getMessage()
                );

                return $this->redirectToRoute('security_login');
            }

            $url = $this->generateUrl(
                'security_reset_password',
                ['resetToken' => $token],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            //Send email
            $message = (new Email())
                ->subject('Reinitialisation de votre mot de passe')
                ->from("nicodupblog@gmail.com")
                ->to($user->getEmail())
                ->html(
                    $this->renderView(
                        'email/reset.html.twig',
                        ['url' => $url]
                    )
                );
            $mailer->send($message);

            $this->addFlash(
                'success',
                'Un email de réinitialisation du mot de passe vous a été envoyé'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/forgottenPassword.html.twig', ['resetForm' => $form->createView()]);
    }

    /**
     * @Route("/reset-pass/{resetToken}/", name="security_reset_password")
     *
     */
    public function resetPassword(
        Request $request,
        $resetToken,
        UserPasswordEncoderInterface $encoder,
        EntityManagerInterface $manager,
        UserRepository $userRepository
    ) {
        $user = $userRepository->findOneBy(['resetToken' => $resetToken]);


        if (!$user) {
            $this->addFlash(
                'danger',
                'Token inconnu'
            );

            return $this->redirectToRoute('security_login');
        }

        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setResetToken(null);

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Mot de passe modifié avec succès !'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'security/resetPassword.html.twig',
            ['resetForm' => $form->createView(), 'resetToken' => $resetToken]
        );

    }
}
