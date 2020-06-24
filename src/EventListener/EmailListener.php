<?php


namespace App\EventListener;

use Symfony\Component\Mailer\Event\MessageEvent;

class EmailListener
{
    public function onMessage(MessageEvent $event){
        die('toto');
    }

}