<?php

namespace App\Entity;

use App\Repository\GroupMembersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupMembersRepository::class)]
class GroupMembers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'groups')]
    private Collection $member;

    #[ORM\ManyToMany(targetEntity: Groups::class, inversedBy: 'members')]
    private Collection $groupe;

    public function __construct()
    {
        $this->member = new ArrayCollection();
        $this->groupe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getMember(): Collection
    {
        return $this->member;
    }

    public function addMember(User $member): static
    {
        if (!$this->member->contains($member)) {
            $this->member->add($member);
        }

        return $this;
    }

    public function removeMember(User $member): static
    {
        $this->member->removeElement($member);

        return $this;
    }

    /**
     * @return Collection<int, Groups>
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groups $groupe): static
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe->add($groupe);
        }

        return $this;
    }

    public function removeGroupe(Groups $groupe): static
    {
        $this->groupe->removeElement($groupe);

        return $this;
    }
}
