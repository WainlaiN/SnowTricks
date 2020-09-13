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
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Services\Mailer;


class SecurityController extends AbstractController
{


    /**
     * @Route("/registration", name="security_registration")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param UploadHelper $uploadHelper
     * @param Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registration(
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordEncoderInterface $encoder,
        UploadHelper $uploadHelper,
        Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($encoder->encodePassword($user, $user->getPassword()))
                ->setActivationToken($tokenGenerator->generateToken())
                ->setRoles();

            if ($user->getFile()) {

                $user->setPhoto($uploadHelper->savePicture($user->getFile()));
            }

            $manager->persist($user);
            $manager->flush();

            $mailer->setMessage(
                'Activation de votre compte!',
                $user->getEmail(),
                $this->renderView(
                    'email/activation.html.twig',
                    ['token' => $user->getActivationToken()]
                ),
                true
            );

            $this->addFlash('success', 'Votre compte a été enregistré, vérifiez vos emails pour l\'activation !');

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
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
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
     */
    public function logout()
    {

    }


    /**
     * @Route("/activate/{token}", name="security_activate")
     *
     * @param $token
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activate($token, UserRepository $userRepository, EntityManagerInterface $manager)
    {
        $user = $userRepository->findOneBy(['activationToken' => $token]);

        if (!$user) {
            $this->addFlash(
                'danger',
                'Problème d\'identification !'
            );

            return $this->redirectToRoute('security_login');
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
     * @param Request $request
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $manager
     * @param Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function forgottenPassword(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $manager,
        Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->get('email')->getData();
            $user = $userRepository->findOneBy(['email' => $email]);

            if (!$user) {
                $this->addFlash('danger', 'Cet email n\'existe pas!');

                return $this->redirectToRoute('security_login');
            }

            $user->setResetToken($tokenGenerator->generateToken());
            $manager->persist($user);
            $manager->flush();

            $url = $this->generateUrl(
                'security_reset_password',
                ['resetToken' => $token],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $mailer->setMessage(
                'Reinitialisation de votre mot de passe',
                $user->getEmail(),
                $this->renderView(
                    'email/reset.html.twig',
                    ['url' => $url]
                ),
                true
            );

            $this->addFlash(
                'success',
                'Un email de réinitialisation du mot de passe vous a été envoyé'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/forgotten_password.html.twig', ['resetForm' => $form->createView()]);
    }


    /**
     * @Route("/reset-pass/{resetToken}/", name="security_reset_password")
     *
     * @param Request $request
     * @param $resetToken
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $manager
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
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

            $user->setResetToken(null)
                ->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Mot de passe modifié avec succès !'
            );

            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'security/reset_password.html.twig',
            ['resetForm' => $form->createView(), 'resetToken' => $resetToken]
        );

    }

}
