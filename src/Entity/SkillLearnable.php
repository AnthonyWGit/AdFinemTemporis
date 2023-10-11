<?php

namespace App\Entity;

use App\Repository\SkillLearnableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillLearnableRepository::class)]
class SkillLearnable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $level = null;

    #[ORM\OneToMany(mappedBy: 'Skill_Learnable', targetEntity: DemonBase::class)]
    private Collection $demonBases;

    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'skillsLearnables')]
    private Collection $Skill;

    public function __construct()
    {
        $this->demonBases = new ArrayCollection();
        $this->Skill = new ArrayCollection();
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

    /**
     * @return Collection<int, DemonBase>
     */
    public function getDemonBases(): Collection
    {
        return $this->demonBases;
    }

    public function addDemonBasis(DemonBase $demonBasis): static
    {
        if (!$this->demonBases->contains($demonBasis)) {
            $this->demonBases->add($demonBasis);
            $demonBasis->setSkillLearnable($this);
        }

        return $this;
    }

    public function removeDemonBasis(DemonBase $demonBasis): static
    {
        if ($this->demonBases->removeElement($demonBasis)) {
            // set the owning side to null (unless already changed)
            if ($demonBasis->getSkillLearnable() === $this) {
                $demonBasis->setSkillLearnable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkill(): Collection
    {
        return $this->Skill;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->Skill->contains($skill)) {
            $this->Skill->add($skill);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        $this->Skill->removeElement($skill);

        return $this;
    }
}
