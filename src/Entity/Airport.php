<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "post"={"validation_groups"={"Default", "postValidation"},
 *                  {"access_control"="is_granted('ROLE_ADMIN')"}
 *}
 *     },
 *     itemOperations={
 *         "delete",
 *         "get"={"access_control"="is_granted('ROLE_ADMIN') "},
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"read_airport"}},
 *     denormalizationContext={"groups"={"write_airport"}}
 * )
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
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Groups({"read_airport", "write_airport"})
     */
    private $name;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="departure_airport")
     * @Groups("read")
     * @Assert\NotIdenticalTo(
     *     propertyPath="arrival_airports"
     * )
     * @Groups({"read_airport", "write_airport"})
     */
    private $flights;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="arrival_airport")
     * @Groups("read")
     * @Assert\NotIdenticalTo(
     *     propertyPath="flights"
     * )
     * @Groups({"read_airport", "write_airport"})
     */
    private $arrival_airports;

    /**
     * Airport constructor
     */
    public function __construct()
    {
        $this->flights          = new ArrayCollection();
        $this->arrival_airports = new ArrayCollection();
    }

    /**
     * getId function
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * getName function
     *
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * setName function
     *
     * @param string $name
     *
     * @return Airport
     */
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

    /**
     * addFlight function
     *
     * @param Flight $flight
     *
     * @return Airport
     */
    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->setDepartureAirport($this);
        }

        return $this;
    }

    /**
     * removeFlight function
     *
     * @param Flight $flight
     *
     * @return Airport
     */
    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getDepartureAirport() === $this) {
                $flight->setDepartureAirport(null);
            }
        }

        return $this;
    }

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
