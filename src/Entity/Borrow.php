<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BorrowRepository")
 */
class Borrow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $BorrowingDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $ReturnDate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $State;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CopyBook", mappedBy="borrow")
     */
    private $CopyBook_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Borrowers", inversedBy="borrows")
     */
    private $Borrowers_id;

    public function __construct()
    {
        $this->CopyBook_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowingDate(): ?\DateTimeInterface
    {
        return $this->BorrowingDate;
    }

    public function setBorrowingDate(?\DateTimeInterface $BorrowingDate): self
    {
        $this->BorrowingDate = $BorrowingDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->ReturnDate;
    }

    public function setReturnDate(?\DateTimeInterface $ReturnDate): self
    {
        $this->ReturnDate = $ReturnDate;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->State;
    }

    public function setState(?int $State): self
    {
        $this->State = $State;

        return $this;
    }

    /**
     * @return Collection|CopyBook[]
     */
    public function getCopyBookId(): Collection
    {
        return $this->CopyBook_id;
    }

    public function addCopyBookId(CopyBook $copyBookId): self
    {
        if (!$this->CopyBook_id->contains($copyBookId)) {
            $this->CopyBook_id[] = $copyBookId;
            $copyBookId->setBorrow($this);
        }

        return $this;
    }

    public function removeCopyBookId(CopyBook $copyBookId): self
    {
        if ($this->CopyBook_id->contains($copyBookId)) {
            $this->CopyBook_id->removeElement($copyBookId);
            // set the owning side to null (unless already changed)
            if ($copyBookId->getBorrow() === $this) {
                $copyBookId->setBorrow(null);
            }
        }

        return $this;
    }

    public function getBorrowersId(): ?Borrowers
    {
        return $this->Borrowers_id;
    }

    public function setBorrowersId(?Borrowers $Borrowers_id): self
    {
        $this->Borrowers_id = $Borrowers_id;

        return $this;
    }
}
