<?php

namespace App\Entity;

use App\Repository\AvatarsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvatarsRepository::class)]
class Avatars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'skin', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\Column(length: 7)]
    private ?string $skin = null;

    #[ORM\Column(length: 7)]
    private ?string $shirt = null;

    #[ORM\Column(length: 7)]
    private ?string $pants = null;

    #[ORM\Column(length: 7)]
    private ?string $hair = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getSkin(): ?string
    {
        return $this->skin;
    }

    public function setSkin(string $skin): static
    {
        $this->skin = $skin;

        return $this;
    }

    public function getShirt(): ?string
    {
        return $this->shirt;
    }

    public function setShirt(string $shirt): static
    {
        $this->shirt = $shirt;

        return $this;
    }

    public function getPants(): ?string
    {
        return $this->pants;
    }

    public function setPants(string $pants): static
    {
        $this->pants = $pants;

        return $this;
    }

    public function getHair(): ?string
    {
        return $this->hair;
    }

    public function setHair(string $hair): static
    {
        $this->hair = $hair;

        return $this;
    }
}
