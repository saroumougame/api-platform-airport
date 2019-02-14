<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 */
class Flight
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
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "trop long {{ limit }} characters"
     * )
     */
    private $reference;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Assert\NotIdenticalTo(
     *     propertyPath="arrival_airport"
     * )
     */
    private $departure_airport;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="arrival_airports")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Assert\NotIdenticalTo(
     *     propertyPath="departure_airport"
     * )
     */
    private $arrival_airport;
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @Assert\NotIdenticalTo(
     *     propertyPath="arrival_date"
     * )
     */
    private $departure_date;
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @Assert\NotIdenticalTo(
     *     propertyPath="departure_date"
     * )
     * @Assert\Callback("App\Validator\FlightDateValidator", "validateDate")
     */
    private $arrival_date;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flights")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $plane;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crew", inversedBy="flights")
     * @Assert\NotBlank
     */
    private $crew;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="flight")
     * @Assert\NotBlank
     * @ApiSubresource(maxDepth=1)
     */
    private $bookings;

    /**
     * Flight constructor
     */
    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    /**
     * Description getId function
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Description getReference function
     *
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Description setReference function
     *
     * @param string $reference
     *
     * @return Flight
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Description getDepartureAirport function
     *
     * @return Airport|null
     */
    public function getDepartureAirport(): ?Airport
    {
        return $this->departure_airport;
    }

    /**
     * Description setDepartureAirport function
     *
     * @param Airport|null $departure_airport
     *
     * @return Flight
     */
    public function setDepartureAirport(?Airport $departure_airport): self
    {
        $this->departure_airport = $departure_airport;

        return $this;
    }

    /**
     * Description getArrivalAirport function
     *
     * @return Airport|null
     */
    public function getArrivalAirport(): ?Airport
    {
        return $this->arrival_airport;
    }

    /**
     * Description setArrivalAirport function
     *
     * @param Airport|null $arrival_airport
     *
     * @return Flight
     */
    public function setArrivalAirport(?Airport $arrival_airport): self
    {
        $this->arrival_airport = $arrival_airport;

        return $this;
    }

    /**
     * Description getDepartureDate function
     *
     * @return \DateTimeInterface|null
     */
    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departure_date;
    }

    /**
     * Description setDepartureDate function
     *
     * @param \DateTimeInterface $departure_date
     *
     * @return Flight
     */
    public function setDepartureDate(\DateTimeInterface $departure_date): self
    {
        $this->departure_date = $departure_date;

        return $this;
    }

    /**
     * Description getArrivalDate function
     *
     * @return \DateTimeInterface|null
     */
    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrival_date;
    }

    /**
     * Description setArrivalDate function
     *
     * @param \DateTimeInterface $arrival_date
     *
     * @return Flight
     */
    public function setArrivalDate(\DateTimeInterface $arrival_date): self
    {
        $this->arrival_date = $arrival_date;

        return $this;
    }

    /**
     * Description getPlane function
     *
     * @return Plane|null
     */
    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    /**
     * Description setPlane function
     *
     * @param Plane|null $plane
     *
     * @return Flight
     */
    public function setPlane(?Plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }

    /**
     * Description getCrew function
     *
     * @return Crew|null
     */
    public function getCrew(): ?Crew
    {
        return $this->crew;
    }

    /**
     * Description setCrew function
     *
     * @param Crew|null $crew
     *
     * @return Flight
     */
    public function setCrew(?Crew $crew): self
    {
        $this->crew = $crew;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    //    public function addBooking(Booking $booking): self
    //    {
    //        if (!$this->bookings->contains($booking)) {
    //            $this->bookings[] = $booking;
    //            $booking->setFlight($this);
    //        }
    //
    //        return $this;
    //    }
    //
    //    public function removeBooking(Booking $booking): self
    //    {
    //        if ($this->bookings->contains($booking)) {
    //            $this->bookings->removeElement($booking);
    //            // set the owning side to null (unless already changed)
    //            if ($booking->getFlight() === $this) {
    //                $booking->setFlight(null);
    //            }
    //        }
    //
    //        return $this;
    //    }
}
