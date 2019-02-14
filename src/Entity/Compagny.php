<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CompagnyRepository")
 * @ApiResource()
 */
class Compagny
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
     * @Assert\Type("string")
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "The company name must be at least {{ limit }} characters long",
     *      maxMessage = "The company name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="company")
     */
    private $planes;

    /**
     * Compagny constructor
     */
    public function __construct()
    {
        $this->planes = new ArrayCollection();
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
     * @return Compagny
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

    /**
     * addPlane function
     *
     * @param Plane $plane
     *
     * @return Compagny
     */
    public function addPlane(Plane $plane): self
    {
        if (!$this->planes->contains($plane)) {
            $this->planes[] = $plane;
            $plane->setCompany($this);
        }

        return $this;
    }

    /**
     * removePlane function
     *
     * @param Plane $plane
     *
     * @return Compagny
     */
    public function removePlane(Plane $plane): self
    {
        if ($this->planes->contains($plane)) {
            $this->planes->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getCompany() === $this) {
                $plane->setCompany(null);
            }
        }

        return $this;
    }
}
