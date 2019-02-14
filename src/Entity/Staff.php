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
 *          }
 *     },
 *     itemOperations={
 *         "delete",
 *         "get"={"access_control"="is_granted('ROLE_ADMIN') "},
 *         "put"={"validation_groups"={"Default", "putValidation"}}
 *     },
 *     normalizationContext={"groups"={"read_staff"}},
 *     denormalizationContext={"groups"={"write_staff"}}
 * )
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
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 50,
     *      minMessage = "min {{ limit }} characters ",
     *      maxMessage = "max {{ limit }} characters"
     * )
     * @Groups("read_staff", "write_staff")
     */
    private $firstname;
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @Groups("read_staff", "write_staff")
     */
    private $lastname;
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @Groups("read_staff", "write_staff")
     */
    private $job;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Crew", mappedBy="staffs")
     * @Groups("read_staff")
     */
    private $crews;

    /**
     * Staff constructor
     */
    public function __construct()
    {
        $this->crews = new ArrayCollection();
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
     * getFirstname function
     *
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * setFirstname function
     *
     * @param string $firstname
     *
     * @return Staff
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * getLastname function
     *
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * setLastname function
     *
     * @param string $lastname
     *
     * @return Staff
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * getJob function
     *
     * @return null|string
     */
    public function getJob(): ?string
    {
        return $this->job;
    }

    /**
     * setJob function
     *
     * @param string $job
     *
     * @return Staff
     */
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
