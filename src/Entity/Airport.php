<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 */
class Airport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="departure_airport")
     */
    private $flights;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="arrival_airport")
     */
    private $arrival_airports;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
        $this->arrival_airports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

//    public function addFlight(Flight $flight): self
//    {
//        if (!$this->flights->contains($flight)) {
//            $this->flights[] = $flight;
//            $flight->setDepartureAirport($this);
//        }
//
//        return $this;
//    }

//    public function removeFlight(Flight $flight): self
//    {
//        if ($this->flights->contains($flight)) {
//            $this->flights->removeElement($flight);
//            // set the owning side to null (unless already changed)
//            if ($flight->getDepartureAirport() === $this) {
//                $flight->setDepartureAirport(null);
//            }
//        }
//
//        return $this;
//    }

    /**
     * @return Collection|Flight[]
     */
    public function getArrivalAirports(): Collection
    {
        return $this->arrival_airports;
    }

//    public function addArrivalAirport(Flight $arrivalAirport): self
//    {
//        if (!$this->arrival_airports->contains($arrivalAirport)) {
//            $this->arrival_airports[] = $arrivalAirport;
//            $arrivalAirport->setArrivalAirport($this);
//        }
//
//        return $this;
//    }
//
//    public function removeArrivalAirport(Flight $arrivalAirport): self
//    {
//        if ($this->arrival_airports->contains($arrivalAirport)) {
//            $this->arrival_airports->removeElement($arrivalAirport);
//            // set the owning side to null (unless already changed)
//            if ($arrivalAirport->getArrivalAirport() === $this) {
//                $arrivalAirport->setArrivalAirport(null);
//            }
//        }
//
//        return $this;
//    }
}
