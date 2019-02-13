<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CopyBookRepository")
 */
class CopyBook
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CopyBookNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="copyBooks")
     */
    private $Book_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Borrow", inversedBy="CopyBook_id")
     */
    private $borrow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCopyBookNumber(): ?int
    {
        return $this->CopyBookNumber;
    }

    public function setCopyBookNumber(?int $CopyBookNumber): self
    {
        $this->CopyBookNumber = $CopyBookNumber;

        return $this;
    }

    public function getBookId(): ?Book
    {
        return $this->Book_id;
    }

    public function setBookId(?Book $Book_id): self
    {
        $this->Book_id = $Book_id;

        return $this;
    }

    public function getBorrow(): ?Borrow
    {
        return $this->borrow;
    }

    public function setBorrow(?Borrow $borrow): self
    {
        $this->borrow = $borrow;

        return $this;
    }
}
