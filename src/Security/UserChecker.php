<?php


namespace App\Security;


use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;



class UserChecker implements UserCheckerInterface
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    public function checkPreAuth(UserInterface $user)
    {

        // if user ActivationToken is still in DB,
        if ($user->getActivationToken()) {

            //$this->session->getFlashBag()->add('danger', 'Vous devez activer votre compte avant la connexion !');


            throw new TokenException('Vous devez activer votre compte avant la connexion !');

        }
    }

    /**public function checkPostAuth(UserInterface $user)
     * {
     * if (!$user instanceof AppUser) {
     * return;
     * }
     *
     * // user account is expired, the user may be notified
     * if ($user->isExpired()) {
     * throw new AccountExpiredException('...');
     * }
     * }**/
    public function checkPostAuth(UserInterface $user)
    {
        // TODO: Implement checkPostAuth() method.
    }
}