<?php

namespace App\Entity;

use App\Repository\GroupsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupsRepository::class)]
class Groups
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: GroupMembers::class, mappedBy: 'groupe')]
    private Collection $members;

    #[ORM\OneToOne(mappedBy: 'groups', cascade: ['persist', 'remove'])]
    private ?GroupChat $chat = null;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, GroupMembers>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(GroupMembers $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addGroupe($this);
        }

        return $this;
    }

    public function removeMember(GroupMembers $member): static
    {
        if ($this->members->removeElement($member)) {
            $member->removeGroupe($this);
        }

        return $this;
    }

    public function getChat(): ?GroupChat
    {
        return $this->chat;
    }

    public function setChat(GroupChat $chat): static
    {
        // set the owning side of the relation if necessary
        if ($chat->getGroups() !== $this) {
            $chat->setGroups($this);
        }

        $this->chat = $chat;

        return $this;
    }
}
