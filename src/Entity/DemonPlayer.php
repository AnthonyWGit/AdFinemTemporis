<?php

namespace App\Entity;

use App\Entity\DemonBase;
use App\Service\LevelCalculator;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemonPlayerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: DemonPlayerRepository::class)]
class DemonPlayer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $str_points = 0;

    #[ORM\Column]
    private ?int $end_points = 0;

    #[ORM\Column]
    private ?int $agi_points = 0;

    #[ORM\Column]
    private ?int $int_points = 0;

    #[ORM\Column]
    private ?int $lck_points = 0;

    #[ORM\Column]
    private ?int $Experience = 0;

    #[ORM\Column]
    private ?int $LvlUp_Points = 0;

    #[ORM\ManyToOne(inversedBy: 'Demon_Player')]
    private ?Player $player = null;



    #[ORM\ManyToOne(inversedBy: 'demon_player')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DemonTrait $trait = null;

    #[ORM\ManyToOne(inversedBy: 'demonPlayers')]
    private ?DemonBase $demon_base = null;

    #[ORM\OneToMany(mappedBy: 'demonPlayer1', targetEntity: Battle::class)]
    private Collection $fighter;

    #[ORM\OneToMany(mappedBy: 'demonPlayer2', targetEntity: Battle::class)]
    private Collection $fighter2;

    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'demonPlayers')]
    private Collection $skill;

    public function __construct()
    {
        $this->fighter = new ArrayCollection();
        $this->fighter2 = new ArrayCollection();
        $this->skill = new ArrayCollection();
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

    public function addStrPoint(int $str_points): static
    {
        $currentPts = $this->getStrPoints();
        $this->str_points = $str_points + $currentPts;
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

    public function addEndPoint(int $end_points): static
    {
        $currentPts = $this->getAgiPoints();
        $this->end_points = $end_points + $currentPts;
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

    public function addAgiPoint(int $agi_points): static
    {
        $currentPts = $this->getAgiPoints();
        $this->agi_points = $agi_points + $currentPts;
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

    public function addIntPoint(int $int_points): static
    {
        $currentPts = $this->getIntPoints();
        $this->int_points = $int_points + $currentPts;
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

    public function addLckPoint(int $lck_points): static
    {
        $currentPts = $this->getLckPoints();
        $this->lck_points = $lck_points + $currentPts;
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

    public function addLvlUpPoints(int $LvlUp_Points): static
    {
        $initalPts = $this->getLvlUpPoints();
        $this->LvlUp_Points = $LvlUp_Points + $initalPts;
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

    /**
     * @return Collection<int, Battle>
     */
    public function getFighter(): Collection
    {
        return $this->fighter;
    }

    public function addFighter(Battle $fighter): static
    {
        if (!$this->fighter->contains($fighter)) {
            $this->fighter->add($fighter);
            $fighter->setDemonPlayer1($this);
        }

        return $this;
    }

    public function removeFighter(Battle $fighter): static
    {
        if ($this->fighter->removeElement($fighter)) {
            // set the owning side to null (unless already changed)
            if ($fighter->getDemonPlayer1() === $this) {
                $fighter->setDemonPlayer1(null);
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
            $fighter2->setDemonPlayer2($this);
        }

        return $this;
    }

    public function removeFighter2(Battle $fighter2): static
    {
        if ($this->fighter2->removeElement($fighter2)) {
            // set the owning side to null (unless already changed)
            if ($fighter2->getDemonPlayer2() === $this) {
                $fighter2->setDemonPlayer2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skill;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skill->contains($skill)) {
            $this->skill->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        $this->skill->removeElement($skill);

        return $this;
    }

    public function getLevel() : int
    {
        $experience = $this->getExperience();
        return LevelCalculator::calculateLevel($experience);
    }

    public function getMaxHp() : int
    {
        $baseEnd = $this->getDemonBase()->getEndDemonBase();
        $bonusLvlUpPoints = $this->getLvlUpPoints() * 10;
        $bonusEndPoints = $this->getEndPoints();
        $level = $this->getLevel();
        $total = $baseEnd + ($bonusEndPoints * 20) + $bonusLvlUpPoints;
        $baseHp = $this->getDemonBase()->getBaseHp();
        return LevelCalculator::calcMaxHp($total, $baseHp,$level);
    }

    //Simulation properties
    public function getMaxHpFictif(int $levelFictif, int $totalEnd, DemonBase $demonBase) : int
    {
        $LvlUpPointsNumber = $levelFictif - 1;
        $bonusLvlUpPointsValue = $LvlUpPointsNumber * 10;
        $baseEndPts = $totalEnd - $demonBase->getEndDemonBase();
        $total = $demonBase->getEndDemonBase() + ($baseEndPts * 20) + $bonusLvlUpPointsValue;
        $baseHp = $demonBase->getBaseHp();
        return LevelCalculator::calcMaxHp($total, $baseHp,$levelFictif);
    }

    public function getTotalStr(): int
    {
        return $this->getStrPoints() + $this->getDemonBase()->getStrDemonBase();
    }

    public function getTotalEnd(): int
    {
        return $this->getEndPoints() + $this->getDemonBase()->getEndDemonBase();
    }

    public function getTotalAgi(): int
    {
        return $this->getAgiPoints() + $this->getDemonBase()->getAgiDemonBase();
    }

    public function getTotalInt(): int
    {
        return $this->getIntPoints() + $this->getDemonBase()->getIntDemonBase();
    }

    public function getTotalLck(): int
    {
        return $this->getLckPoints() + $this->getDemonBase()->getLckDemonBase();
    }

}
