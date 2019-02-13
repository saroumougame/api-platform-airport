<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CrewRepository")
 */
class Crew
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", inversedBy="crews")
     */
    private $staffs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="crew")
     */
    private $flights;

    public function __construct()
    {
        $this->staffs = new ArrayCollection();
        $this->flights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Staff[]
     */
    public function getStaffs(): Collection
    {
        return $this->staffs;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staffs->contains($staff)) {
            $this->staffs[] = $staff;
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staffs->contains($staff)) {
            $this->staffs->removeElement($staff);
        }

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
//            $flight->setCrew($this);
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
//            if ($flight->getCrew() === $this) {
//                $flight->setCrew(null);
//            }
//        }
//
//        return $this;
//    }
}
