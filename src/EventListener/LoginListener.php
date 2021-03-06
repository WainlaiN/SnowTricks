<?php


namespace App\EventListener;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * LoginListener constructor.
     *
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        $user = $event->getAuthenticationToken()->getUser();

        //check if token activation token is still present
        if ($user->getActivationToken()) {

            throw new CustomUserMessageAuthenticationException ('Votre compte n\'est pas activé, vérifiez vos emails !');
        }



    }
}