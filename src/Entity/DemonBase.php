<?php

namespace App\Entity;

use App\Repository\DemonBaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemonBaseRepository::class)]
class DemonBase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $str_demon_base = null;

    #[ORM\Column]
    private ?int $end_demon_base = null;

    #[ORM\Column]
    private ?int $agi_demon_base = null;

    #[ORM\Column]
    private ?int $int_demon_base = null;

    #[ORM\Column]
    private ?int $lck_demon_base = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\OneToMany(mappedBy: 'Demon_Base', targetEntity: DemonPlayer::class)]
    private Collection $demonPlayers;

    #[ORM\ManyToOne(inversedBy: 'demonBases')]
    private ?SkillLearnable $Skill_Learnable = null;

    public function __construct()
    {
        $this->demonPlayers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStrDemonBase(): ?int
    {
        return $this->str_demon_base;
    }

    public function setStrDemonBase(int $str_demon_base): static
    {
        $this->str_demon_base = $str_demon_base;

        return $this;
    }

    public function getEndDemonBase(): ?int
    {
        return $this->end_demon_base;
    }

    public function setEndDemonBase(int $end_demon_base): static
    {
        $this->end_demon_base = $end_demon_base;

        return $this;
    }

    public function getAgiDemonBase(): ?int
    {
        return $this->agi_demon_base;
    }

    public function setAgiDemonBase(int $agi_demon_base): static
    {
        $this->agi_demon_base = $agi_demon_base;

        return $this;
    }

    public function getIntDemonBase(): ?int
    {
        return $this->int_demon_base;
    }

    public function setIntDemonBase(int $int_demon_base): static
    {
        $this->int_demon_base = $int_demon_base;

        return $this;
    }

    public function getLckDemonBase(): ?int
    {
        return $this->lck_demon_base;
    }

    public function setLckDemonBase(int $lck_demon_base): static
    {
        $this->lck_demon_base = $lck_demon_base;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

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
            $demonPlayer->setDemonBase($this);
        }

        return $this;
    }

    public function removeDemonPlayer(DemonPlayer $demonPlayer): static
    {
        if ($this->demonPlayers->removeElement($demonPlayer)) {
            // set the owning side to null (unless already changed)
            if ($demonPlayer->getDemonBase() === $this) {
                $demonPlayer->setDemonBase(null);
            }
        }

        return $this;
    }

    public function getSkillLearnable(): ?SkillLearnable
    {
        return $this->Skill_Learnable;
    }

    public function setSkillLearnable(?SkillLearnable $Skill_Learnable): static
    {
        $this->Skill_Learnable = $Skill_Learnable;

        return $this;
    }
}
