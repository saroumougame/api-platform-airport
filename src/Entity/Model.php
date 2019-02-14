<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 */
class Model
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
     *      max = 50,
     *      maxMessage = "max {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="integer",
     *     message="{{ value }} veuillez saisir un entier."
     * )
     */
    private $sits;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="model")
     * @Assert\NotBlank
     */
    private $planes;

    public function __construct()
    {
        $this->planes = new ArrayCollection();
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

    public function getSits(): ?int
    {
        return $this->sits;
    }

    public function setSits(int $sits): self
    {
        $this->sits = $sits;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

//    public function addPlane(Plane $plane): self
//    {
//        if (!$this->planes->contains($plane)) {
//            $this->planes[] = $plane;
//            $plane->setModel($this);
//        }
//
//        return $this;
//    }
//
//    public function removePlane(Plane $plane): self
//    {
//        if ($this->planes->contains($plane)) {
//            $this->planes->removeElement($plane);
//            // set the owning side to null (unless already changed)
//            if ($plane->getModel() === $this) {
//                $plane->setModel(null);
//            }
//        }
//
//        return $this;
//    }
}
