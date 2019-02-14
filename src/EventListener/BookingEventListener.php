<?php

namespace App\EventListener;

use App\Entity\Booking;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class BookingEventListener
{
    /**
     * onKernelView function
     *
     * @param GetResponseForControllerResultEvent $event
     *
     * @return void
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        /** @var Booking $user */
        $booking = $event->getControllerResult();
        if ($booking instanceof Booking) {
            $booking->setStatus('processing');
        }
    }
}