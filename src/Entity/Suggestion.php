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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $postDate = null;

    #[ORM\OneToMany(mappedBy: 'send', targetEntity: Player::class)]
    private Collection $PlayersSuggestions;

    #[ORM\ManyToMany(targetEntity: Player::class, mappedBy: 'likes')]
    private Collection $PlayersLikes;

    public function __construct()
    {
        $this->PlayersSuggestions = new ArrayCollection();
        $this->PlayersLikes = new ArrayCollection();
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

    public function getPostDate(): ?\DateTimeInterface
    {
        return $this->postDate;
    }

    public function getPostDateFormat(): ?string
    {
        return $this->postDate->format('Y-m-d H:i:s');
    }

    public function setPostDate(\DateTimeInterface $postDate): static
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayersSuggestions(): Collection
    {
        return $this->PlayersSuggestions;
    }

    public function getPlayersSuggestionsCount(): int
    {
        return count($this->PlayersSuggestions);
    }

    public function addPlayersSuggestion(Player $playersSuggestion): static
    {
        if (!$this->PlayersSuggestions->contains($playersSuggestion)) {
            $this->PlayersSuggestions->add($playersSuggestion);
            $playersSuggestion->setSend($this);
        }

        return $this;
    }

    public function removePlayersSuggestion(Player $playersSuggestion): static
    {
        if ($this->PlayersSuggestions->removeElement($playersSuggestion)) {
            // set the owning side to null (unless already changed)
            if ($playersSuggestion->getSend() === $this) {
                $playersSuggestion->setSend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayersLikes(): Collection
    {
        return $this->PlayersLikes;
    }

    public function getPlayersLikesCount(): int
    {
        return count($this->PlayersLikes);
    }

    public function addPlayersLike(Player $playersLike): static
    {
        if (!$this->PlayersLikes->contains($playersLike)) {
            $this->PlayersLikes->add($playersLike);
            $playersLike->addLike($this);
        }

        return $this;
    }

    public function removePlayersLike(Player $playersLike): static
    {
        if ($this->PlayersLikes->removeElement($playersLike)) {
            $playersLike->removeLike($this);
        }

        return $this;
    }

}
