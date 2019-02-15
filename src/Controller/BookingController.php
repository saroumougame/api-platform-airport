<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class BookingController extends Controller
{



    public function __invoke(Booking $data)
    {

       $place = $data->getFlight()->getPlane()->getModel()->getSits();
        $nbBooking = $this->getDoctrine()->getRepository(Booking::class)->nbrReservation();
        $placeDispo = $place - $nbBooking;

        $array = [
            'nbPlaceDisplo' => $placeDispo
        ];
        $response = json_encode($array);

        return $response;
    }
}