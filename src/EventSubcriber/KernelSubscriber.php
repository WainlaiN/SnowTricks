<?php


namespace App\EventSubcriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            kernelEvents::EXCEPTION => [
                ['showErrorMessage' , 10]
            ]
        ];
    }

    public function showErrorMessage() {
        dump('Something wrong happened');
    }
}