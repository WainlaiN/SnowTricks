<?php


namespace App\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class KernelSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            kernelEvents::REQUEST => [
                ['onRequest', 10]
            ]
        ];
    }

    public function onRequest(RequestEvent $event) {

        //$response = new Redirec('/error404', 301);
        //$event->setResponse($response);

        //dump('Something wrong happened');
    }
}