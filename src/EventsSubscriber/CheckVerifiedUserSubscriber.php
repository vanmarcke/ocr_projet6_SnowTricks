<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public function onCheckPassport(CheckPassportEvent $event)
    {
        dd($event);
    }

    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => 'onCheckPassport',
        ];
    }
}
