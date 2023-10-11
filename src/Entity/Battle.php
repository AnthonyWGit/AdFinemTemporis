<?php

namespace App\Entity;

use App\Repository\BattleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'fighter1', targetEntity: DemonPlayer::class)]
    private Collection $demonsPlayer1;

    #[ORM\OneToMany(mappedBy: 'fighter2', targetEntity: DemonPlayer::class)]
    private Collection $demonsPlayer2;

    #[ORM\ManyToOne(inversedBy: 'fighter')]
    private ?DemonPlayer $demonPlayer1 = null;

    #[ORM\ManyToOne(inversedBy: 'fighter2')]
    private ?DemonPlayer $demonPlayer2 = null;

    public function __construct()
    {
        $this->demonsPlayer1 = new ArrayCollection();
        $this->demonsPlayer2 = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, DemonPlayer>
     */
    public function getDemonsPlayer1(): Collection
    {
        return $this->demonsPlayer1;
    }

    public function addDemonsPlayer1(DemonPlayer $demonsPlayer1): static
    {
        if (!$this->demonsPlayer1->contains($demonsPlayer1)) {
            $this->demonsPlayer1->add($demonsPlayer1);
            $demonsPlayer1->setFighter1($this);
        }

        return $this;
    }

    public function removeDemonsPlayer1(DemonPlayer $demonsPlayer1): static
    {
        if ($this->demonsPlayer1->removeElement($demonsPlayer1)) {
            // set the owning side to null (unless already changed)
            if ($demonsPlayer1->getFighter1() === $this) {
                $demonsPlayer1->setFighter1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DemonPlayer>
     */
    public function getDemonsPlayer2(): Collection
    {
        return $this->demonsPlayer2;
    }

    public function addDemonsPlayer2(DemonPlayer $demonsPlayer2): static
    {
        if (!$this->demonsPlayer2->contains($demonsPlayer2)) {
            $this->demonsPlayer2->add($demonsPlayer2);
            $demonsPlayer2->setFighter2($this);
        }

        return $this;
    }

    public function removeDemonsPlayer2(DemonPlayer $demonsPlayer2): static
    {
        if ($this->demonsPlayer2->removeElement($demonsPlayer2)) {
            // set the owning side to null (unless already changed)
            if ($demonsPlayer2->getFighter2() === $this) {
                $demonsPlayer2->setFighter2(null);
            }
        }

        return $this;
    }

    public function getDemonPlayer1(): ?DemonPlayer
    {
        return $this->demonPlayer1;
    }

    public function setDemonPlayer1(?DemonPlayer $demonPlayer1): static
    {
        $this->demonPlayer1 = $demonPlayer1;

        return $this;
    }

    public function getDemonPlayer2(): ?DemonPlayer
    {
        return $this->demonPlayer2;
    }

    public function setDemonPlayer2(?DemonPlayer $demonPlayer2): static
    {
        $this->demonPlayer2 = $demonPlayer2;

        return $this;
    }
}
