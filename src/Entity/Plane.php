<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PlaneRepository")
 */
class Plane
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
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "max {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      max = 50,
     *      minMessage = "min {{ limit }} characters long",
     *      maxMessage = "max {{ limit }} characters"
     * )
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Model", inversedBy="planes")
     * @Assert\NotBlank
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Compagny", inversedBy="planes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="plane")
     * @Assert\NotBlank
     */
    private $flights;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
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

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getCompany(): ?Compagny
    {
        return $this->company;
    }

    public function setCompany(?Compagny $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

//    public function addFlight(Flight $flight): self
//    {
//        if (!$this->flights->contains($flight)) {
//            $this->flights[] = $flight;
//            $flight->setPlane($this);
//        }
//
//        return $this;
//    }
//
//    public function removeFlight(Flight $flight): self
//    {
//        if ($this->flights->contains($flight)) {
//            $this->flights->removeElement($flight);
//            // set the owning side to null (unless already changed)
//            if ($flight->getPlane() === $this) {
//                $flight->setPlane(null);
//            }
//        }
//
//        return $this;
//    }
}
