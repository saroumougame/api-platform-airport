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
 *     normalizationContext={"groups"={"read_luggage"}},
 *     denormalizationContext={"groups"={"write_luggage"}}
 * )
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
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} n'est pas une valeur correcte."
     * )
     * @Groups({"read_luggage", "write_luggage"})
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="string",
     *     message="{{ value }} n'est pas une valeur correcte."
     * )
     * @Groups({"read_luggage", "write_luggage"})
     */
    private $reference;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     * @Assert\Type("decimal")
     * @Groups({"read_luggage", "write_luggage"})
     */
    private $weight;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="luggages")
     * @Groups({"read_luggage"})
     */
    private $bookings;

    /**
     * Luggage constructor
     */
    public function __construct()
    {
        $this->bookings = new ArrayCollection();
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
     * @return Luggage
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
     * @return Luggage
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * getWeight function
     *
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * setWeight function
     *
     * @param $weight
     *
     * @return Luggage
     */
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
