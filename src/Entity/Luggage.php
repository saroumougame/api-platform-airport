<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\LuggageRepository")
 */
class Luggage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="luggages")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight): self
    {
        $this->weight = $weight;

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
//            $booking->setLuggages($this);
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
//            if ($booking->getLuggages() === $this) {
//                $booking->setLuggages(null);
//            }
//        }
//
//        return $this;
//    }
}
