<?php

namespace App\Entity;

use App\Repository\ReaderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReaderRepository::class)
 */
class Reader
{
    use TimestampsTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="borrowed_to")
     */
    private $borrowed_books;

    public function __construct()
    {
        $this->borrowed_books = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBorrowedBooks(): Collection
    {
        return $this->borrowed_books;
    }

    public function addBorrowedBook(Book $borrowedBook): self
    {
        if (!$this->borrowed_books->contains($borrowedBook)) {
            $this->borrowed_books[] = $borrowedBook;
            $borrowedBook->setBorrowedTo($this);
        }

        return $this;
    }

    public function removeBorrowedBook(Book $borrowedBook): self
    {
        if ($this->borrowed_books->contains($borrowedBook)) {
            $this->borrowed_books->removeElement($borrowedBook);
            // set the owning side to null (unless already changed)
            if ($borrowedBook->getBorrowedTo() === $this) {
                $borrowedBook->setBorrowedTo(null);
            }
        }

        return $this;
    }
}
