<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
 *     normalizationContext={"groups"={"read_model"}},
 *     denormalizationContext={"groups"={"write_model"}}
 * )
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
     * @Groups({"read_model", "write_model"})
     */
    private $name;
    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="integer",
     *     message="{{ value }} veuillez saisir un entier."
     * )
     * @Groups({"read_model", "write_model"})
     */
    private $sits;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="model")
     * @Assert\NotBlank
     * @Groups({"read_model"})
     */
    private $planes;

    /**
     * Model constructor
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
     * @return Model
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * getSits function
     *
     * @return int|null
     */
    public function getSits(): ?int
    {
        return $this->sits;
    }

    /**
     * setSits function
     *
     * @param int $sits
     *
     * @return Model
     */
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
