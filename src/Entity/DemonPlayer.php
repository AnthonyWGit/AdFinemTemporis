<?php

namespace App\Entity;

use App\Repository\DemonPlayerRepository;
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

    #[ORM\Column]
    private ?int $Experience = null;

    #[ORM\Column]
    private ?int $LvlUp_Points = null;

    #[ORM\ManyToOne(inversedBy: 'Demon_Player')]
    private ?Player $player = null;

    #[ORM\ManyToOne(inversedBy: 'demonsPlayer1')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Battle $fighter1 = null;

    #[ORM\ManyToOne(inversedBy: 'demonsPlayer2')]
    private ?Battle $fighter2 = null;

    #[ORM\ManyToOne(inversedBy: 'demon_base')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DemonTrait $trait = null;

    #[ORM\ManyToOne(inversedBy: 'demonPlayers')]
    private ?DemonBase $demon_base = null;

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

    public function getFighter1(): ?Battle
    {
        return $this->fighter1;
    }

    public function setFighter1(?Battle $fighter1): static
    {
        $this->fighter1 = $fighter1;

        return $this;
    }

    public function getFighter2(): ?Battle
    {
        return $this->fighter2;
    }

    public function setFighter2(?Battle $fighter2): static
    {
        $this->fighter2 = $fighter2;

        return $this;
    }

    public function getTrait(): ?DemonTrait
    {
        return $this->trait;
    }

    public function setTrait(?DemonTrait $trait): static
    {
        $this->trait = $trait;

        return $this;
    }

    public function getDemonBase(): ?DemonBase
    {
        return $this->demon_base;
    }

    public function setDemonBase(?DemonBase $demon_base): static
    {
        $this->demon_base = $demon_base;

        return $this;
    }
}
