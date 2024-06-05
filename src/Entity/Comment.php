<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\News;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: News::class, inversedBy: 'comments', cascade: ['persist'], fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: false)]
    private ?News $news = null;

    #[ORM\Column(type: 'text')]
    private ?string $body;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $createdAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \App\Entity\News|null
     */
    public function getNews(): ?\App\Entity\News
    {
        return $this->news;
    }

    /**
     * @param \App\Entity\News|null $news
     */
    public function setNews(?\App\Entity\News $news): static
    {
        $this->news = $news;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string|null $body
     */
    public function setBody(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     */
    public function setCreatedAt(?string $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}