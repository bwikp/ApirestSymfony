<?php

namespace App\Entity;

use App\Repository\LegalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegalRepository::class)]
class Legal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rgpd = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRgpd(): ?string
    {
        return $this->rgpd;
    }

    public function setRgpd(?string $rgpd): static
    {
        $this->rgpd = $rgpd;

        return $this;
    }
}
