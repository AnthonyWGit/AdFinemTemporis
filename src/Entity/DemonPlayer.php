<?php

namespace App\Entity;

use App\Repository\DemonPlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemonPlayerRepository::class)]
class DemonPlayer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $str_points = null;

    #[ORM\Column]
    private ?int $end_points = null;

    #[ORM\Column]
    private ?int $agi_points = null;

    #[ORM\Column]
    private ?int $int_points = null;

    #[ORM\Column]
    private ?int $lck_points = null;

    #[ORM\Column(length: 50)]
    private ?string $Trait = null;

    #[ORM\Column]
    private ?int $Experience = null;

    #[ORM\Column]
    private ?int $LvlUp_Points = null;

    #[ORM\ManyToOne(inversedBy: 'demon_player')]
    private ?Player $player = null;

    #[ORM\OneToMany(mappedBy: 'demonplayer1', targetEntity: Battle::class)]
    private Collection $fighter1;

    #[ORM\OneToMany(mappedBy: 'demonplayer2', targetEntity: Battle::class)]
    private Collection $fighter2;

    #[ORM\ManyToOne(inversedBy: 'demonPlayers')]
    private ?DemonTrait $trait = null;

    #[ORM\ManyToOne(inversedBy: 'demonPlayers')]
    private ?DemonBase $Demon_Base = null;

    public function __construct()
    {
        $this->fighter1 = new ArrayCollection();
        $this->fighter2 = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStrPoints(): ?int
    {
        return $this->str_points;
    }

    public function setStrPoints(int $str_points): static
    {
        $this->str_points = $str_points;

        return $this;
    }

    public function getEndPoints(): ?int
    {
        return $this->end_points;
    }

    public function setEndPoints(int $end_points): static
    {
        $this->end_points = $end_points;

        return $this;
    }

    public function getAgiPoints(): ?int
    {
        return $this->agi_points;
    }

    public function setAgiPoints(int $agi_points): static
    {
        $this->agi_points = $agi_points;

        return $this;
    }

    public function getIntPoints(): ?int
    {
        return $this->int_points;
    }

    public function setIntPoints(int $int_points): static
    {
        $this->int_points = $int_points;

        return $this;
    }

    public function getLckPoints(): ?int
    {
        return $this->lck_points;
    }

    public function setLckPoints(int $lck_points): static
    {
        $this->lck_points = $lck_points;

        return $this;
    }

    public function getTrait(): ?string
    {
        return $this->Trait;
    }

    public function setTrait(string $Trait): static
    {
        $this->Trait = $Trait;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->Experience;
    }

    public function setExperience(int $Experience): static
    {
        $this->Experience = $Experience;

        return $this;
    }

    public function getLvlUpPoints(): ?int
    {
        return $this->LvlUp_Points;
    }

    public function setLvlUpPoints(int $LvlUp_Points): static
    {
        $this->LvlUp_Points = $LvlUp_Points;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): static
    {
        $this->player = $player;

        return $this;
    }

    /**
     * @return Collection<int, Battle>
     */
    public function getFighter1(): Collection
    {
        return $this->fighter1;
    }

    public function addFighter1(Battle $fighter1): static
    {
        if (!$this->fighter1->contains($fighter1)) {
            $this->fighter1->add($fighter1);
            $fighter1->setDemonplayer1($this);
        }

        return $this;
    }

    public function removeFighter1(Battle $fighter1): static
    {
        if ($this->fighter1->removeElement($fighter1)) {
            // set the owning side to null (unless already changed)
            if ($fighter1->getDemonplayer1() === $this) {
                $fighter1->setDemonplayer1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Battle>
     */
    public function getFighter2(): Collection
    {
        return $this->fighter2;
    }

    public function addFighter2(Battle $fighter2): static
    {
        if (!$this->fighter2->contains($fighter2)) {
            $this->fighter2->add($fighter2);
            $fighter2->setDemonplayer2($this);
        }

        return $this;
    }

    public function removeFighter2(Battle $fighter2): static
    {
        if ($this->fighter2->removeElement($fighter2)) {
            // set the owning side to null (unless already changed)
            if ($fighter2->getDemonplayer2() === $this) {
                $fighter2->setDemonplayer2(null);
            }
        }

        return $this;
    }

    public function getDemonBase(): ?DemonBase
    {
        return $this->Demon_Base;
    }

    public function setDemonBase(?DemonBase $Demon_Base): static
    {
        $this->Demon_Base = $Demon_Base;

        return $this;
    }
}
