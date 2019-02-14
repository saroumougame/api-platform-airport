<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
 *     normalizationContext={"groups"={"read_ticket"}},
 *     denormalizationContext={"groups"={"write_ticket"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
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
     *     message="{{ value }} n'est une valeur correct."
     * )
     * @Groups("read_ticket")
     */
    private $reference;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups("read_ticket")
     */
    private $flight;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups("read_ticket")
     */
    private $customer;
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="integer",
     *     message="{{ value }} veuillez saisir un entier."
     * )
     * @Groups("read_ticket")
     */
    private $sit;

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
     * @return Ticket
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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
     * @return Ticket
     */
    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

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
     * @return Ticket
     */
    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * getSit function
     *
     * @return int|null
     */
    public function getSit(): ?int
    {
        return $this->sit;
    }

    /**
     * setSit function
     *
     * @param int $sit
     *
     * @return Ticket
     */
    public function setSit(int $sit): self
    {
        $this->sit = $sit;

        return $this;
    }
}
