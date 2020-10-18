<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Book
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
    private $author;

    /**
     * @ORM\Column(type="boolean")
     */
    private $to_sell;

    /**
     * @ORM\ManyToOne(targetEntity=Reader::class, inversedBy="borrowed_books")
     */
    private $borrowed_to;

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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getToSell(): ?bool
    {
        return $this->to_sell;
    }

    public function setToSell(bool $to_sell): self
    {
        $this->to_sell = $to_sell;

        return $this;
    }

    public function getBorrowedTo(): ?Reader
    {
        return $this->borrowed_to;
    }

    public function setBorrowedTo(?Reader $borrowed_to): self
    {
        $this->borrowed_to = $borrowed_to;

        return $this;
    }
}
