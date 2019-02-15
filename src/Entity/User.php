<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
 * @UniqueEntity("email")
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
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="customer")
     */
    private $tickets;

    /**
     * User constructor
     */
    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->tickets  = new ArrayCollection();
    }

    /**
     * getId function
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * getPassword function
     *
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * setPassword function
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * getPlainPassword function
     *
     * @return null|string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * setPlainPassword function
     *
     * @param string $plainPassword
     *
     * @return User
     */
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

    /**
     * eraseCredentials function
     *
     * @return void
     */
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

    /**
     * getRoles function
     *
     * @return array
     */
    public function getRoles()
    {
        $role   = $this->roles;
        $role[] = 'ROLE_USER';

        return array_unique($this->roles);
    }

    /**
     * setRoles function
     *
     * @param $roles
     *
     * @return $this
     */
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

    /**
     * addBooking function
     *
     * @param Booking $booking
     *
     * @return User
     */
    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setCustomer($this);
        }

        return $this;
    }

    /**
     * removeBooking function
     *
     * @param Booking $booking
     *
     * @return User
     */
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
     * @return User
     */
    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setCustomer($this);
        }

        return $this;
    }

    /**
     * removeTicket function
     *
     * @param Ticket $ticket
     *
     * @return User
     */
    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getCustomer() === $this) {
                $ticket->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * getLastName function
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * setLastName function
     *
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * getFirstName function
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * setFirstName function
     *
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * getEmail function
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * setEmail function
     *
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
}
