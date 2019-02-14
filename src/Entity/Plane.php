<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiSubresource;
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
 *     normalizationContext={"groups"={"read_plane"}},
 *     denormalizationContext={"groups"={"write_plane"}}
 * )
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

    /**
     * Plane constructor
     */
    public function __construct()
    {
        $this->flights = new ArrayCollection();
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
     * @return Plane
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
     * @return Plane
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * getModel function
     *
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * setModel function
     *
     * @param Model|null $model
     *
     * @return Plane
     */
    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * getCompany function
     *
     * @return Compagny|null
     */
    public function getCompany(): ?Compagny
    {
        return $this->company;
    }

    /**
     * setCompany function
     *
     * @param Compagny|null $company
     *
     * @return Plane
     */
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
