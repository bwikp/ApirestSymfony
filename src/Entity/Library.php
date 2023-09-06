<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $idlivre = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'lib')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $livretitle = null;

    #[ORM\ManyToOne(inversedBy: 'libraries')]
    private ?category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdlivre(): ?string
    {
        return $this->idlivre;
    }

    public function setIdlivre(string $idlivre): static
    {
        $this->idlivre = $idlivre;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLivretitle(): ?string
    {
        return $this->livretitle;
    }

    public function setLivretitle(string $livretitle): static
    {
        $this->livretitle = $livretitle;

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
