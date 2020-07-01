<?php


namespace App\EventListener;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($user->getActivationToken()) {

            $this->session->getFlashBag()->add('danger', 'Vous devez activer votre compte avant la connexion !');

            return new RedirectResponse('security_login');

        }
    }
}