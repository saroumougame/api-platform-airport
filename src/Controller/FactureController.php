<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller;

use App\Entity\Booking;

class FactureController
{


    public function __invoke(Booking $data)
    {
        dump($data);
        var_dump('tototo');
        return 'coucou';
    }
}