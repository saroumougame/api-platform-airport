<?php

namespace App\EventListener;

use App\Entity\Booking;
use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class BookingEventListener
{
    /** @var EntityManagerInterface $em */
    private $em;

    /**
     * BookingEventListener constructor
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['generateTicket', EventPriorities::POST_WRITE],
        ];
    }


    /**
     * onKernelView function
     *
     * @param GetResponseForControllerResultEvent $event
     *
     * @return void
     * @internal param ObjectManager $manager
     */
    public function generateTicket(GetResponseForControllerResultEvent $event)
    {
        /** @var Booking $user */
        $booking = $event->getControllerResult();

        $request = $event->getRequest()->getMethod();

        if ($booking instanceof Booking && $request == 'POST') {
            /** @var string $bookingStatus */
            $bookingStatus = $booking->getStatus();

            if ($bookingStatus == '') {
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

            $this->em->persist($ticket);
            $this->em->flush();
        }




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