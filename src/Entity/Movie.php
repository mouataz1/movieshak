<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 * @ApiResource(
 *     attributes={
 *     "pagination_enabled"=true,
 *     "order": {"date"="desc"}
 *     },
 *          normalizationContext={
 *          "groups"={"movies_read"}
 *     }
 * )
 * @ApiFilter(SearchFilter::class, properties={"title":"partial"})
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"movies_read", "comments_read", "users_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"movies_read", "comments_read", "users_read"})
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"movies_read", "comments_read", "users_read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"movies_read", "comments_read", "users_read"})
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"movies_read", "comments_read", "users_read"})
     */
    private $watchLink;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"movies_read", "comments_read", "users_read"})
     */
    private $stars;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="movie_id")
     * @Groups({"movies_read", "users_read"})
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments_read", "users_read"})
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="movie_id")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"movies_read", "comments_read"})
     */
    private $user;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getWatchLink(): ?string
    {
        return $this->watchLink;
    }

    public function setWatchLink(string $watchLink): self
    {
        $this->watchLink = $watchLink;

        return $this;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(?int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setMovieId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getMovieId() === $this) {
                $comment->setMovieId(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
