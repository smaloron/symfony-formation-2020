<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Regex(pattern="/^[a-z éèêâàç\-]*$/i", message="Uniquement des caractères alphabétiques")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Regex(pattern="/^[a-z éèêâàç\-]*$/i", message="Uniquement des caractères alphabétiques")
     */
    private $firstName;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThan("-18 years", message="Un auteur doit ête majeur")
     */
    private $dateOfBirth;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function __toString()
    {
        $fullName = "";

        if(! empty($this->firstName)){
            $fullName .= $this->firstName. " ";
        }

        $fullName .= strtoupper($this->name);

        return $fullName;
    }


}
