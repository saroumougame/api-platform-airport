<?php

namespace App\Validator;

use App\Entity\Flight;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class FlightDateValidator
{
    /**
     * Check departure and arrival date
     *
     * @param Flight $object
     * @param ExecutionContextInterface $context
     * @param $payload
     *
     * @return void
     */
    public function validateDate(Flight $object, ExecutionContextInterface $context, $payload)
    {
        /** @var \DateTime $departureDate */
        $departureDate = $object->getDepartureDate();
        /** @var \DateTime $arrivalDate */
        $arrivalDate = $object->getArrivalDate();

        if ($arrivalDate <= $departureDate) {
            $context->buildViolation('The arrival date is not valid!')
                ->atPath('arrival_airport')
                ->addViolation()
            ;
        }
    }
}
