<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_USER')"},
 *         "post"={"validation_groups"={"Default", "postValidation"},
 *                  {"access_control"="is_granted('ROLE_USER')"}
 *          }
 *     },
 *     itemOperations={
 *         "delete",
 *         "get"={"access_control"="is_granted('ROLE_USER') "},
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"read_flight"}},
 *     denormalizationContext={"groups"={"write_flight"}}
 * )
 * @Assert\Callback({"App\Validator\FlightDateValidator", "validateDate"})
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
     * @Groups("read_flight", "write_flight")
     */
    private $reference;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Assert\NotIdenticalTo(
     *     propertyPath="arrival_airport"
     * )
     * @Groups("read_flight", "write_flight")
     */
    private $departure_airport;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="arrival_airports")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Assert\NotIdenticalTo(
     *     propertyPath="departure_airport"
     * )
     * @Groups("read_flight", "write_flight")
     */
    private $arrival_airport;
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @Assert\NotIdenticalTo(
     *     propertyPath="arrival_date"
     * )
     * @Groups("read_flight", "write_flight")
     */
    private $departure_date;
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @Assert\NotIdenticalTo(
     *     propertyPath="departure_date"
     * )
     * @Groups("read_flight", "write_flight")
     */
    private $arrival_date;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flights")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups("read_flight", "write_flight")
     */
    private $plane;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crew", inversedBy="flights")
     * @Assert\NotBlank
     * @Groups("read_flight", "write_flight")
     */
    private $crew;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="flight")
     * @Assert\NotBlank
     * @ApiSubresource(maxDepth=1)
     * @Groups("read_flight")
     */
    private $bookings;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="flight")
     */
    private $tickets;

    /**
     * Flight constructor
     */
    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->tickets  = new ArrayCollection();
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
     * getReference function
     *
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * setReference function
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
     * getDepartureAirport function
     *
     * @return Airport|null
     */
    public function getDepartureAirport(): ?Airport
    {
        return $this->departure_airport;
    }

    /**
     * setDepartureAirport function
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
     * getArrivalAirport function
     *
     * @return Airport|null
     */
    public function getArrivalAirport(): ?Airport
    {
        return $this->arrival_airport;
    }

    /**
     * setArrivalAirport function
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
     * getDepartureDate function
     *
     * @return \DateTimeInterface|null
     */
    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departure_date;
    }

    /**
     * setDepartureDate function
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
     * getArrivalDate function
     *
     * @return \DateTimeInterface|null
     */
    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrival_date;
    }

    /**
     * setArrivalDate function
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
     * getPlane function
     *
     * @return Plane|null
     */
    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    /**
     * setPlane function
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
     * getCrew function
     *
     * @return Crew|null
     */
    public function getCrew(): ?Crew
    {
        return $this->crew;
    }

    /**
     * setCrew function
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

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    /**
     * addTicket function
     *
     * @param Ticket $ticket
     *
     * @return Flight
     */
    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setFlight($this);
        }

        return $this;
    }

    /**
     * removeTicket function
     *
     * @param Ticket $ticket
     *
     * @return Flight
     */
    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getFlight() === $this) {
                $ticket->setFlight(null);
            }
        }

        return $this;
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
