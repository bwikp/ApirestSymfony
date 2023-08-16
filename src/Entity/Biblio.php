<?php

namespace App\Entity;

use App\Repository\BiblioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BiblioRepository::class)]
class Biblio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $idlivre = null;

    #[ORM\Column(length: 255)]
    private ?string $note = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?user $user = null;

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

    public function setNote(string $note): static
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
}
