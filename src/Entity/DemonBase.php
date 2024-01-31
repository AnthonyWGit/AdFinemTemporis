<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemonBaseRepository;
use App\Repository\SkillTableRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
    private ?int $inte_demon_base = null;

    #[ORM\Column]
    private ?int $lck_demon_base = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\OneToMany(mappedBy: 'demon_base', targetEntity: DemonPlayer::class)]
    private Collection $demonPlayers;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'demonBase', targetEntity: SkillTable::class)]
    private Collection $skill_table;

    #[ORM\Column(length: 255)]
    private ?string $pantheon = null;

    #[ORM\Column]
    private ?int $baseHp = 1;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lore = null;

    public function __construct()
    {
        $this->demonPlayers = new ArrayCollection();
        $this->skill_table = new ArrayCollection();
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
        return $this->inte_demon_base;
    }

    public function setIntDemonBase(int $inte_demon_base): static
    {
        $this->inte_demon_base = $inte_demon_base;

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
     * @return Collection<int, SkillTable>
     */
    public function getSkillTable(): Collection
    {
        return $this->skill_table;
    }

    public function addSkillTable(SkillTable $skillTable): static
    {
        if (!$this->skill_table->contains($skillTable)) {
            $this->skill_table->add($skillTable);
            $skillTable->setDemonBase($this);
        }

        return $this;
    }

    public function removeSkillTable(SkillTable $skillTable): static
    {
        if ($this->skill_table->removeElement($skillTable)) {
            // set the owning side to null (unless already changed)
            if ($skillTable->getDemonBase() === $this) {
                $skillTable->setDemonBase(null);
            }
        }

        return $this;
    }

    public function getPantheon(): ?string
    {
        return $this->pantheon;
    }

    public function setPantheon(string $pantheon): static
    {
        $this->pantheon = $pantheon;

        return $this;
    }

    public function getBaseHp(): ?int
    {
        return $this->baseHp;
    }

    public function setBaseHp(int $baseHp): static
    {
        $this->baseHp = $baseHp;

        return $this;
    }

    public function getLore(): ?string
    {
        return $this->lore;
    }

    public function setLore(?string $lore): static
    {
        $this->lore = $lore;

        return $this;
    }

    public function getSkillsBelow(?SkillTableRepository $skillTableRepository,  $level, $idDemon)
    {
        return $skillTableRepository->findSkillsBelowOrEqualToLevel($level, $idDemon);
    }
    
}
