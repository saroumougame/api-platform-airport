<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_USER')"},
 *         "post"={"validation_groups"={"Default", "postValidation"},
 *                  {"access_control"="is_granted('ROLE_ADMIN')"}
 *}
 *     },
 *     itemOperations={
 *         "delete",
 *         "get"={"access_control"="is_granted('ROLE_ADMIN') "},
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"read_classes"}},
 *     denormalizationContext={"groups"={"write_classes"}}
 * )
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
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "The class name must be at least {{ limit }} characters long",
     *      maxMessage = "The class name cannot be longer than {{ limit }} characters"
     * )
     */
    private $nom;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="class")
     */
    private $bookings;

    /**
     * Classes constructor
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
     * Description getNom function
     *
     * @return null|string
     * @Groups({"read_booking", "write_booking"})
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * setNom function
     *
     * @param string $nom
     *
     * @return Classes
     */
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


//    public function __toString()
//    {
//        return (string) $this->getNom();
//    }

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
