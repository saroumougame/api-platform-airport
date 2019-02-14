<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User entity
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get",
 *         "post"={"validation_groups"={"Default", "postValidation"}}
 *     },
 *     itemOperations={
 *         "delete",
 *         "get",
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity
 * @ORM\Table(name="user_account")
 * @Assert\UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Lastname
     *
     * @ORM\Column
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public $lastName = '';

    /**
     * @var string Firstname
     *
     * @ORM\Column
     * @Assert\NotBlank
     * @Groups({"read", "write"})
     */
    public $firstName = '';

    /**
     * @var string User's Email
     *
     * @ORM\Column
     * @Assert\NotBlank
     * @Assert\Email(message="Your email is not valid")
     * @Groups({"read", "write"})
     */
    public $email = '';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var string PlainPassword
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="6",
     *     groups={"postValidation", "putValidation"}
     * )
     * @Assert\NotEqualTo(
     *     propertyPath="password",
     *     groups={"putValidation"}
     * )
     *
     * @Groups({"write"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     * @Groups({"write"})
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="customer")
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        $role = $this->roles;
        $role[] = 'ROLE_USER';

        return array_unique($this->roles);
    }

    public function setRoles($roles)
    {

        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setCustomer($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getCustomer() === $this) {
                $booking->setCustomer(null);
            }
        }

        return $this;
    }
}