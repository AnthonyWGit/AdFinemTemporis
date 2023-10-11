<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?float $gold = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column]
    private ?int $stage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registerDate = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: HaveItem::class)]
    private Collection $Have_Item;

    #[ORM\OneToMany(mappedBy: 'player', targetEntity: DemonPlayer::class)]
    private Collection $demon_player;

    #[ORM\ManyToMany(targetEntity: Suggestion::class, inversedBy: 'playersLikes')]
    private Collection $Likes;

    #[ORM\ManyToOne(inversedBy: 'playersSuggestion')]
    private ?Suggestion $send = null;

    public function __construct()
    {
        $this->Have_Item = new ArrayCollection();
        $this->Likes = new ArrayCollection();
        $this->demon_player = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getGold(): ?float
    {
        return $this->gold;
    }

    public function setGold(float $gold): static
    {
        $this->gold = $gold;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getStage(): ?int
    {
        return $this->stage;
    }

    public function setStage(int $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

    public function getRegisterDate(): ?\DateTimeInterface
    {
        return $this->registerDate;
    }

    public function setRegisterDate(\DateTimeInterface $registerDate): static
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, HaveItem>
     */
    public function getHaveItem(): Collection
    {
        return $this->Have_Item;
    }

    public function addHaveItem(HaveItem $haveItem): static
    {
        if (!$this->Have_Item->contains($haveItem)) {
            $this->Have_Item->add($haveItem);
            $haveItem->setPlayer($this);
        }

        return $this;
    }

    public function removeHaveItem(HaveItem $haveItem): static
    {
        if ($this->Have_Item->removeElement($haveItem)) {
            // set the owning side to null (unless already changed)
            if ($haveItem->getPlayer() === $this) {
                $haveItem->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemonPlayer>
     */
    public function getDemonPlayer(): Collection
    {
        return $this->demon_player;
    }

    public function addDemonPlayer(DemonPlayer $demonPlayer): static
    {
        if (!$this->demon_player->contains($demonPlayer)) {
            $this->demon_player->add($demonPlayer);
            $demonPlayer->setPlayer($this);
        }

        return $this;
    }

    public function removeDemonPlayer(DemonPlayer $demonPlayer): static
    {
        if ($this->demon_player->removeElement($demonPlayer)) {
            // set the owning side to null (unless already changed)
            if ($demonPlayer->getPlayer() === $this) {
                $demonPlayer->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Suggestion>
     */
    public function getLikes(): Collection
    {
        return $this->Likes;
    }

    public function addLike(Suggestion $like): static
    {
        if (!$this->Likes->contains($like)) {
            $this->Likes->add($like);
        }

        return $this;
    }

    public function removeLike(Suggestion $like): static
    {
        $this->Likes->removeElement($like);

        return $this;
    }

    public function getSend(): ?Suggestion
    {
        return $this->send;
    }

    public function setSend(?Suggestion $send): static
    {
        $this->send = $send;

        return $this;
    }
}
