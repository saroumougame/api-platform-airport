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
 *         "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "post"={"validation_groups"={"Default", "postValidation"},
 *                  {"access_control"="is_granted('ROLE_ADMIN')"}
 *}
 *     },
 *     itemOperations={
 *         "delete",
 *         "get"={"access_control"="is_granted('ROLE_ADMIN') "},
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"read_crew"}},
 *     denormalizationContext={"groups"={"write_crew"}}
 * )
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
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $reference;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", inversedBy="crews")
     * @Assert\NotBlank
     * @Groups({"read_booking", "write_booking", "read_staff"})
     */
    private $staffs;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="crew")
     * @Groups({"read_booking", "write_booking", "read_staff"})
     */
    private $flights;

    /**
     * Crew constructor
     */
    public function __construct()
    {
        $this->staffs  = new ArrayCollection();
        $this->flights = new ArrayCollection();
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
     * Description getReference function
     *
     * @return null|string
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * Description setReference function
     *
     * @param string $reference
     *
     * @return Crew
     */
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

    /**
     * Description addStaff function
     *
     * @param Staff $staff
     *
     * @return Crew
     */
    public function addStaff(Staff $staff): self
    {
        if (!$this->staffs->contains($staff)) {
            $this->staffs[] = $staff;
        }

        return $this;
    }

    /**
     * Description removeStaff function
     *
     * @param Staff $staff
     *
     * @return Crew
     */
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
