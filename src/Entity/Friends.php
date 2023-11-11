<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FriendsRepository::class)]
class Friends
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'friends')]
    private Collection $sender;

    //#[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'friends')]
    private Collection $receiver;

    #[ORM\Column]
    private ?bool $is_pending = null;

    #[ORM\OneToOne(mappedBy: 'friendship', cascade: ['persist', 'remove'])]
    private ?FriendChat $chat = null;

    public function __construct()
    {
        $this->sender = new ArrayCollection();
        $this->receiver = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSender(): Collection
    {
        return $this->sender;
    }

    public function addSender(User $sender): static
    {
        if (!$this->sender->contains($sender)) {
            $this->sender->add($sender);
        }

        return $this;
    }

    public function removeSender(User $sender): static
    {
        $this->sender->removeElement($sender);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getReceiver(): Collection
    {
        return $this->receiver;
    }

    public function addReceiver(User $receiver): static
    {
        if (!$this->receiver->contains($receiver)) {
            $this->receiver->add($receiver);
        }

        return $this;
    }

    public function removeReceiver(User $receiver): static
    {
        $this->receiver->removeElement($receiver);

        return $this;
    }

    public function isIsPending(): ?bool
    {
        return $this->is_pending;
    }

    public function setIsPending(bool $is_pending): static
    {
        $this->is_pending = $is_pending;

        return $this;
    }

    public function getChat(): ?FriendChat
    {
        return $this->chat;
    }

    public function setChat(FriendChat $chat): static
    {
        // set the owning side of the relation if necessary
        if ($chat->getFriendship() !== $this) {
            $chat->setFriendship($this);
        }

        $this->chat = $chat;

        return $this;
    }
}
