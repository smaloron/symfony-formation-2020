<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le titre ne peut être vide")
     * @Assert\Length(max="150", min="5",
     *      maxMessage="Le titre ne peut comporter plus de {{ limit }} caractères",
     *      minMessage="Le titre doit faire au moins {{ limit }} caractères"
     * )
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author")
     */
    private $author;

    /**
     * @Assert\NotBlank(message="La date ne peut être vide")
     * @Assert\LessThanOrEqual("today",
     *     message="La date de publication ne peut être dans l'avenir")
     * @ORM\Column(type="date")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $publisher;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @Assert\IsTrue(message="Les livres de SF ne peuvent coûter plus de 30 euros")
     * @return bool
     */
    public function isPriceOfSFBooksLessThanValid(){
        if($this->genre == "SF" && $this->price > 30){
            return false;
        } else {
            return true;
        }
    }
}
