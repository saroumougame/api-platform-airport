<?php

namespace App\Validator;

use App\Entity\Crew;
use App\Entity\Flight;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\Response;

class CrewLimitPeopleValidator
{
    /**
     * Check departure and arrival date
     *
     * @param Crew $crew
     * @param ExecutionContextInterface $context
     * @param $payload
     *
     * @return Response
     */
    public static function validateCrew(Crew $crew, ExecutionContextInterface $context, $payload)
    {

        $staff = $crew->getStaffs();

        $nbStaff = count($staff);

        if ($nbStaff < 3) {
            $context->buildViolation('The crew limit is 3')
                ->atPath('staffs')
                ->addViolation()
            ;

            return new Response('the crew limit');
        }
    }
}
