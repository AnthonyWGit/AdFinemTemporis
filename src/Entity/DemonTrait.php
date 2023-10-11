<?php

namespace App\Entity;

use App\Repository\DemonTraitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemonTraitRepository::class)]
class DemonTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $strength = null;

    #[ORM\Column]
    private ?int $endurance = null;

    #[ORM\Column]
    private ?int $agility = null;

    #[ORM\Column]
    private ?int $intelligence = null;

    #[ORM\Column]
    private ?int $luck = null;

    #[ORM\OneToMany(mappedBy: 'trait', targetEntity: DemonPlayer::class)]
    private Collection $demon_player;

    public function __construct()
    {
        $this->demon_player = new ArrayCollection();
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

    public function getStrength(): ?int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): static
    {
        $this->strength = $strength;

        return $this;
    }

    public function getEndurance(): ?int
    {
        return $this->endurance;
    }

    public function setEndurance(int $endurance): static
    {
        $this->endurance = $endurance;

        return $this;
    }

    public function getAgility(): ?int
    {
        return $this->agility;
    }

    public function setAgility(int $agility): static
    {
        $this->agility = $agility;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): static
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getLuck(): ?int
    {
        return $this->luck;
    }

    public function setLuck(int $luck): static
    {
        $this->luck = $luck;

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
            $demonPlayer->setTrait($this);
        }

        return $this;
    }

    public function removeDemonPlayer(DemonPlayer $DemonPlayer): static
    {
        if ($this->demon_player->removeElement($DemonPlayer)) {
            // set the owning side to null (unless already changed)
            if ($DemonPlayer->getTrait() === $this) {
                $DemonPlayer->setTrait(null);
            }
        }

        return $this;
    }
}
