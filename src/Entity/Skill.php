<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $baseDmg = null;

    #[ORM\Column(length: 50)]
    private ?string $dmgType = null;

    #[ORM\OneToMany(mappedBy: 'skill', targetEntity: SkillTable::class)]
    private Collection $skill_table;

    #[ORM\ManyToMany(mappedBy: 'skill', targetEntity: DemonPlayer::class)]
    private Collection $demonPlayers;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    public function __construct()
    {
        $this->demonPlayers = new ArrayCollection();
        $this->skill_table = new ArrayCollection();
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

    public function getBaseDmg(): ?int
    {
        return $this->baseDmg;
    }

    public function setBaseDmg(int $baseDmg): static
    {
        $this->baseDmg = $baseDmg;

        return $this;
    }


    public function getDmgType(): ?string
    {
        return $this->dmgType;
    }

    public function setDmgType(string $dmgType): static
    {
        $this->dmgType = $dmgType;

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
            $demonPlayer->addSkill($this);
        }

        return $this;
    }

    public function removeDemonPlayer(DemonPlayer $demonPlayer): static
    {
        if ($this->demonPlayers->removeElement($demonPlayer)) {
            $demonPlayer->removeSkill($this);
        }

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
            $skillTable->setSkill($this);
        }

        return $this;
    }

    public function removeSkillTable(SkillTable $skillTable): static
    {
        if ($this->skill_table->removeElement($skillTable)) {
            // set the owning side to null (unless already changed)
            if ($skillTable->getSkill() === $this) {
                $skillTable->setSkill(null);
            }
        }

        return $this;
    }

    public function dmgCalc(DemonPlayer $demonPlayer1, DemonPlayer $demonPlayer2) : float
    {
        $dmgDone = 0;
        if ($this->getDmgType() == "phys")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + ($demonPlayer1->getTotalStr()));
            $endReduction = ($demonPlayer2->getTotalEnd() * 0.01);
            $dmgDone = $dmgCalcPure - $endReduction;
        }
        else if ($this->getDmgType() == "mag")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + ($demonPlayer1->getTotalInt()));
            $endReduction = ($demonPlayer2->getTotalEnd() * 0.01);
            $dmgDone = $dmgCalcPure - $endReduction;
        }
        else if ($this->getDmgType() == "str/agi")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + (($demonPlayer1->getTotalStr()) * 0.3) + (($demonPlayer1->getTotalAgi() * 0.7)));
            $endReduction = ($demonPlayer2->getTotalEnd() * 0.01);
            $dmgDone = $dmgCalcPure - $endReduction;
        }
        else if ($this->getDmgType() == "int pure")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + ($demonPlayer1->getTotalInt()) * 0.1);
            $dmgDone = $dmgCalcPure;
        }
    
        // Add a random increase of up to 10% to the damage.
        $randomIncrease = mt_rand(100, 110) / 100;
        return ceil($dmgDone * $randomIncrease);
    }

    public function dmgCalcSimulatedPure(DemonPlayer $demonPlayer1) : float
    {
        $dmgDone = 0;
        if ($this->getDmgType() == "phys")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + ($demonPlayer1->getTotalStr()));
            $dmgDone = $dmgCalcPure;
        }
        else if ($this->getDmgType() == "mag")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + ($demonPlayer1->getTotalInt()));
            $dmgDone = $dmgCalcPure;
        }
        else if ($this->getDmgType() == "str/agi")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + (($demonPlayer1->getTotalStr()) * 0.3) + (($demonPlayer1->getTotalAgi() * 0.7)));
            $dmgDone = $dmgCalcPure;
        }
        else if ($this->getDmgType() == "int pure")
        {
            $dmgCalcPure = (($this->getBaseDmg() * 0.1) + ($demonPlayer1->getTotalInt()) * 0.1);
            $dmgDone = $dmgCalcPure;
        }
    
        // Add a random increase of up to 10% to the damage.
        $randomIncrease = mt_rand(100, 110) / 100;
        return ceil($dmgDone * $randomIncrease);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

}
