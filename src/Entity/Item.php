<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'item', targetEntity: HaveItem::class)]
    private Collection $Have_Item;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Category $category = null;

    #[ORM\Column]
    private ?int $cost = null;

    public function __construct()
    {
        $this->Have_Item = new ArrayCollection();
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

    /**
     * @return Collection<int, HaveItem>
     */
    public function getHaveItem(): Collection
    {
        return $this->Have_Item;
    }

    public function addHaveItem(HaveItem $haveItem): static
    {
        if (!$this->Have_Item->contains($haveItem)) {
            $this->Have_Item->add($haveItem);
            $haveItem->setItem($this);
        }

        return $this;
    }

    public function removeHaveItem(HaveItem $haveItem): static
    {
        if ($this->Have_Item->removeElement($haveItem)) {
            // set the owning side to null (unless already changed)
            if ($haveItem->getItem() === $this) {
                $haveItem->setItem(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }
}
