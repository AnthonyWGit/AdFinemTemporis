<?php

namespace App\Entity;

use App\Repository\SkillTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillTableRepository::class)]
class SkillTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\ManyToOne(inversedBy: 'skill_table')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skill $skill = null;

    #[ORM\ManyToOne(inversedBy: 'skill_table')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DemonBase $demonBase = null;

    public function __construct()
    {
        $this->demonBases = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): static
    {
        $this->skill = $skill;

        return $this;
    }

    public function getDemonBase(): ?DemonBase
    {
        return $this->demonBase;
    }

    public function setDemonBase(?DemonBase $demonBase): static
    {
        $this->demonBase = $demonBase;

        return $this;
    }


}
