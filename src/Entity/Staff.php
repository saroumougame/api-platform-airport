<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\StaffRepository")
 */
class Staff
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $job;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crew", mappedBy="staffs")
     */
    private $crews;

    public function __construct()
    {
        $this->crews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }


    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection|Crew[]
     */
    public function getCrews(): Collection
    {
        return $this->crews;
    }

//    public function addCrew(Crew $crew): self
//    {
//        if (!$this->crews->contains($crew)) {
//            $this->crews[] = $crew;
//            $crew->addStaff($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCrew(Crew $crew): self
//    {
//        if ($this->crews->contains($crew)) {
//            $this->crews->removeElement($crew);
//            $crew->removeStaff($this);
//        }
//
//        return $this;
//    }
}
