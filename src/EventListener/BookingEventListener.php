<?php

namespace App\EventListener;

use App\Entity\Booking;
use App\Entity\Ticket;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class BookingEventListener
{
    /**
     * onKernelView function
     *
     * @param GetResponseForControllerResultEvent $event
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function onKernelView(GetResponseForControllerResultEvent $event, ObjectManager $manager)
    {
        /** @var Booking $user */
        $booking = $event->getControllerResult();
        /** @var string $bookingStatus */
        $bookingStatus = $booking->getStatus();
        if ($booking instanceof Booking && $bookingStatus == '') {
            $booking->setStatus('processing');
        }

        /** @var Ticket $ticket */
        $ticket = new Ticket();
        $ticket->setReference($this->random());
        $ticket->setCustomer($booking->getCustomer());
        $ticket->setFlight($booking->getFlight());

        /** @var int $sitRange */
        $sitRange = $booking->getFlight()->getPlane()->getModel()->getSits();
        /** @var int $sit */
        $sit = rand(1, $sitRange);

        $ticket->setSit($sit);

        $manager->persist($ticket);
        $manager->flush();
    }

    /**
     * Generate random string
     *
     * @param int $length
     *
     * @return string
     */
    public function random(int $length = 10): string
    {
        /** @var string $characters */
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        /** @var string $randomString */
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString = $characters[rand(0, strlen($characters))];
        }

        return $randomString;
    }
}