<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToMany(targetEntity: SkillLearnable::class, mappedBy: 'skill')]
    private Collection $skillsLearnables;

    #[ORM\Column(length: 50)]
    private ?string $dmgType = null;

    public function __construct()
    {
        $this->skillsLearnables = new ArrayCollection();
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

    /**
     * @return Collection<int, SkillLearnable>
     */
    public function getSkillsLearnables(): Collection
    {
        return $this->skillsLearnables;
    }

    public function addSkillsLearnable(SkillLearnable $skillsLearnable): static
    {
        if (!$this->skillsLearnables->contains($skillsLearnable)) {
            $this->skillsLearnables->add($skillsLearnable);
            $skillsLearnable->addSkill($this);
        }

        return $this;
    }

    public function removeSkillsLearnable(SkillLearnable $skillsLearnable): static
    {
        if ($this->skillsLearnables->removeElement($skillsLearnable)) {
            $skillsLearnable->removeSkill($this);
        }

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
}
