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
     * @var UploadHelper
     */
    private $uploadHelper;
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(UploadHelper $uploadHelper, Mailer $mailer, EntityManagerInterface $manager)
    {
        $this->uploadHelper = $uploadHelper;
        $this->mailer = $mailer;
        $this->manager = $manager;
    }


    /**
     * @Route("/registration", name="security_registration")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenGeneratorInterface $tokenGenerator
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registration(
        Request $request,
        UserPasswordEncoderInterface $encoder,
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

                $user->setPhoto($this->uploadHelper->savePicture($user->getFile()));
            }

            $this->manager->persist($user);
            $this->manager->flush();

            $this->mailer->setMessage(
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activate($token, UserRepository $userRepository)
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
        $this->manager->persist($user);
        $this->manager->flush();

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
        //EntityManagerInterface $manager,
        //Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $userRepository->findOneBy(['email' => $form->get('email')->getData()]);

            if (!$user) {
                $this->addFlash('danger', 'Cet email n\'existe pas!');

                return $this->redirectToRoute('security_login');
            }

            $token = $tokenGenerator->generateToken();
            $user->setResetToken($token);
            $this->manager->persist($user);
            $this->manager->flush();

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

            $this->addFlash('success', 'Un email de réinitialisation vous a été envoyé');

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
        //EntityManagerInterface $manager,
        UserRepository $userRepository
    ) {
        $user = $userRepository->findOneBy(['resetToken' => $resetToken]);

        if (!$user) {
            $this->addFlash('danger', 'Token inconnu');

            return $this->redirectToRoute('security_login');
        }

        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setResetToken(null)
                ->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', 'Mot de passe modifié avec succès !');

            return $this->redirectToRoute('security_login');
        }

        return $this->render(
            'security/reset_password.html.twig',
            ['resetForm' => $form->createView(), 'resetToken' => $resetToken]
        );

    }

}
