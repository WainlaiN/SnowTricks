<?php

namespace App\Security;


use Symfony\Component\Security\Core\Exception\AccountStatusException;

class TokenException extends AccountStatusException
{
    public function getMessageKey()
    {
        return 'Vous n\'avez pas activé votre compte' ;
    }
}