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

    #[ORM\Column(length: 50)]
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
    private Collection $demonPlayers;

    public function __construct()
    {
        $this->demonPlayers = new ArrayCollection();
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
    public function getDemonPlayers(): Collection
    {
        return $this->demonPlayers;
    }

    public function addDemonPlayer(DemonPlayer $demonPlayer): static
    {
        if (!$this->demonPlayers->contains($demonPlayer)) {
            $this->demonPlayers->add($demonPlayer);
            $demonPlayer->setTrait($this);
        }

        return $this;
    }

    public function removeDemonPlayer(DemonPlayer $demonPlayer): static
    {
        if ($this->demonPlayers->removeElement($demonPlayer)) {
            // set the owning side to null (unless already changed)
            if ($demonPlayer->getTrait() === $this) {
                $demonPlayer->setTrait(null);
            }
        }

        return $this;
    }
}
