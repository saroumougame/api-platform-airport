<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ClassesRepository")
 */
class Classes
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="class")
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
//            $booking->setClass($this);
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
//            if ($booking->getClass() === $this) {
//                $booking->setClass(null);
//            }
//        }
//
//        return $this;
//    }
}
