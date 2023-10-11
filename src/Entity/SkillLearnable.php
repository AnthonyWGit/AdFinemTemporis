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

    #[ORM\OneToMany(mappedBy: 'skill_learnable', targetEntity: DemonBase::class)]
    private Collection $demonsBases;

    #[ORM\ManyToMany(targetEntity: Skill::class, inversedBy: 'skillsLearnables')]
    private Collection $skill;

    public function __construct()
    {
        $this->demonsBases = new ArrayCollection();
        $this->skill = new ArrayCollection();
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
    public function getDemonsBases(): Collection
    {
        return $this->demonsBases;
    }

    public function addDemonsBasis(DemonBase $demonsBasis): static
    {
        if (!$this->demonsBases->contains($demonsBasis)) {
            $this->demonsBases->add($demonsBasis);
            $demonsBasis->setSkillLearnable($this);
        }

        return $this;
    }

    public function removeDemonsBasis(DemonBase $demonsBasis): static
    {
        if ($this->demonsBases->removeElement($demonsBasis)) {
            // set the owning side to null (unless already changed)
            if ($demonsBasis->getSkillLearnable() === $this) {
                $demonsBasis->setSkillLearnable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkill(): Collection
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
}
