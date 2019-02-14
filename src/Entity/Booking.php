<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
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
 *     normalizationContext={"groups"={"read_booking"}},
 *     denormalizationContext={"groups"={"write_booking"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
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
     * @Groups({"read_booking", "write_booking"})
     */
    private $reference;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classes", inversedBy="bookings")
     * @Assert\NotBlank
     * @Groups({"read_booking", "write_booking", "read_classes"})
     */
    private $class;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_booking", "write_booking", "read_flight" })
     */
    private $flight;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Luggage", inversedBy="bookings")
     * @Assert\NotBlank
     * @Groups({"read_booking", "write_booking", "write_luggages" })
     */
    private $luggages;
    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     * @Groups({"read_booking", "write_booking"})
     */
    private $bookingDate;
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"read_booking"})
     */
    private $status;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_booking", "write_booking", "read_user"})
     */
    private $customer;

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
     * @return Booking
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * getClass function
     *
     * @return Classes|null
     */
    public function getClass(): ?Classes
    {
        return $this->class;
    }

    /**
     * setClass function
     *
     * @param Classes|null $class
     *
     * @return Booking
     */
    public function setClass(?Classes $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * getFlight function
     *
     * @return Flight|null
     */
    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    /**
     * setFlight function
     *
     * @param Flight|null $flight
     *
     * @return Booking
     */
    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        return $this;
    }

    /**
     * getLuggages function
     *
     * @return Luggage|null
     */
    public function getLuggages(): ?Luggage
    {
        return $this->luggages;
    }

    /**
     * setLuggages function
     *
     * @param Luggage|null $luggages
     *
     * @return Booking
     */
    public function setLuggages(?Luggage $luggages): self
    {
        $this->luggages = $luggages;

        return $this;
    }

    /**
     * getBookingDate function
     *
     * @return \DateTimeInterface|null
     */
    public function getBookingDate(): ?\DateTimeInterface
    {
        return $this->bookingDate;
    }

    /**
     * setBookingDate function
     *
     * @param \DateTimeInterface $bookingDate
     *
     * @return Booking
     */
    public function setBookingDate(\DateTimeInterface $bookingDate): self
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * getStatus function
     *
     * @return null|string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * setStatus function
     *
     * @param null|string $status
     *
     * @return Booking
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * getCustomer function
     *
     * @return User|null
     */
    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    /**
     * setCustomer function
     *
     * @param User|null $customer
     *
     * @return Booking
     */
    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
