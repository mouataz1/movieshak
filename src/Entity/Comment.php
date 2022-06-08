<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ApiResource(
 *     attributes={
 *     "pagination_enabled"=true,
 *     "pagination_items_per_page"=20
 *     },
 *          normalizationContext={
 *          "groups"={"comments_read"}
 *     },
 *     denormalizationContext={"disable_type_enforcement"=true}
 * )
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comments_read", "users_read", "movies_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comments_read"})
     * @Assert\NotBlank(message="user is required")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"comments_read"})
     * @Assert\NotBlank(message="movie is required")
     */
    private $movie_id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comments_read", "movies_read", "users_read"})
     * @Assert\NotBlank(message="content is required")
     * @Assert\Length(
     *      min = 3,
     *      max = 10000,
     *      minMessage = "content must be at least 3 characters long",
     *      maxMessage = "content cannot be longer than 1000 characters"
     * )
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"comments_read", "users_read","movies_read"})
     * Assert\Type("\DateTimeInterface")
     * @var string A "Y-m-d H:i:s" formatted value
     * @Assert\NotBlank(message="Date is required")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getMovieId(): ?Movie
    {
        return $this->movie_id;
    }

    public function setMovieId(?Movie $movie_id): self
    {
        $this->movie_id = $movie_id;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
}
