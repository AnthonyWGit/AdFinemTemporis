<?php

namespace App\Entity;

use App\Repository\SuggestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuggestionRepository::class)]
class Suggestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $post_content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    #[ORM\Column]
    private ?int $likes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $postDate = null;

    #[ORM\ManyToMany(targetEntity: Player::class, mappedBy: 'Likes')]
    private Collection $playersLikes;

    #[ORM\OneToMany(mappedBy: 'send', targetEntity: Player::class)]
    private Collection $playersSuggestion;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->playersLikes = new ArrayCollection();
        $this->playersSuggestion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPostContent(): ?string
    {
        return $this->post_content;
    }

    public function setPostContent(string $post_content): static
    {
        $this->post_content = $post_content;

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

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->postDate;
    }

    public function setPostDate(\DateTimeInterface $postDate): static
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayersLikes(): Collection
    {
        return $this->playersLikes;
    }

    public function addPlayersLike(Player $playersLike): static
    {
        if (!$this->playersLikes->contains($playersLike)) {
            $this->playersLikes->add($playersLike);
            $playersLike->addLike($this);
        }

        return $this;
    }

    public function removePlayersLike(Player $playersLike): static
    {
        if ($this->playersLikes->removeElement($playersLike)) {
            $playersLike->removeLike($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayersSuggestion(): Collection
    {
        return $this->playersSuggestion;
    }

    public function addPlayersSuggestion(Player $playersSuggestion): static
    {
        if (!$this->playersSuggestion->contains($playersSuggestion)) {
            $this->playersSuggestion->add($playersSuggestion);
            $playersSuggestion->setSend($this);
        }

        return $this;
    }

    public function removePlayersSuggestion(Player $playersSuggestion): static
    {
        if ($this->playersSuggestion->removeElement($playersSuggestion)) {
            // set the owning side to null (unless already changed)
            if ($playersSuggestion->getSend() === $this) {
                $playersSuggestion->setSend(null);
            }
        }

        return $this;
    }

}
