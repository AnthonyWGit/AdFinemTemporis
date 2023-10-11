<?php

namespace App\Entity;

use App\Repository\BattleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BattleRepository::class)]
class Battle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $xpEarned = null;

    #[ORM\Column]
    private ?int $goldEarned = null;

    #[ORM\ManyToOne(inversedBy: 'fighter1')]
    private ?DemonPlayer $demonplayer1 = null;

    #[ORM\ManyToOne(inversedBy: 'fighter2')]
    private ?DemonPlayer $demonplayer2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getXpEarned(): ?int
    {
        return $this->xpEarned;
    }

    public function setXpEarned(int $xpEarned): static
    {
        $this->xpEarned = $xpEarned;

        return $this;
    }

    public function getGoldEarned(): ?int
    {
        return $this->goldEarned;
    }

    public function setGoldEarned(int $goldEarned): static
    {
        $this->goldEarned = $goldEarned;

        return $this;
    }

    public function getDemonplayer1(): ?DemonPlayer
    {
        return $this->demonplayer1;
    }

    public function setDemonplayer1(?DemonPlayer $demonplayer1): static
    {
        $this->demonplayer1 = $demonplayer1;

        return $this;
    }

    public function getDemonplayer2(): ?DemonPlayer
    {
        return $this->demonplayer2;
    }

    public function setDemonplayer2(?DemonPlayer $demonplayer2): static
    {
        $this->demonplayer2 = $demonplayer2;

        return $this;
    }
}
