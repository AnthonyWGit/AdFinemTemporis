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

    #[ORM\ManyToMany(targetEntity: Player::class, mappedBy: 'likes')]
    private Collection $playersLikes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(nullable: false)]
    private ?int $is_verified = 2;

    #[ORM\ManyToOne(inversedBy: 'suggestions')]
    private ?Player $playerSuggestion = null;

    #[ORM\Column(length: 255)]
    private ?string $slug_suggestion = null;

    public function __construct()
    {
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
    public function getPlayersLikes(): Collection
    {
        return $this->playersLikes;
    }

    public function getPlayersLikesCount(): ?int
    {
        return count($this->playersLikes);
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getHiddenStatus(): ?int
    {
        return $this->is_verified;
    }

    public function IsVerified(): ?bool
    {
        if ($this->is_verified == 0)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function setIsVerified(int $is_verified): static
    {
        $this->is_verified = $is_verified;

        return $this;
    }

    public function IsNew(): ?bool
    {
        if ($this->is_verified == 2)
        {
            return true;
        }
        else 
        {
            return false;
        }
    }

    public function getPlayerSuggestion(): ?Player
    {
        return $this->playerSuggestion;
    }

    public function setPlayerSuggestion(?Player $playerSuggestion): static
    {
        $this->playerSuggestion = $playerSuggestion;

        return $this;
    }

    public function displayUsername(): string
    {
        $playerName = $this->playerSuggestion->getUsername();
        return $playerName;
    }

    public function getSlugSuggestion(): ?string
    {
        return $this->slug_suggestion;
    }

    public function setSlugSuggestion(string $slug_suggestion): static
    {
        $this->slug_suggestion = $slug_suggestion;

        return $this;
    }
}
