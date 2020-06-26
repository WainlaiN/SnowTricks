<?php


namespace App\EventSubcriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class EmailSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
           // EmailSentEvent::NAME => 'OnEmailSent'
            ];
            }

    public function showErrorMessage() {
        dump('Something wrong happened');
    }
}