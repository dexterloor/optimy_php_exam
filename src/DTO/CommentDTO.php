<?php

namespace App\DTO;

class CommentDTO
{
    private ?int $news_id;
    private ?string $comment_body;

    /**
     * @param int|null $news_id
     * @param string|null $comment_body
     */
    public function __construct(?int $news_id, ?string $comment_body)
    {
        $this->news_id = $news_id;
        $this->comment_body = $comment_body;
    }

    /**
     * @return int|null
     */
    public function getNewsId(): ?int
    {
        return $this->news_id;
    }

    /**
     * @param int|null $news_id
     */
    public function setNewsId(?int $news_id): void
    {
        $this->news_id = $news_id;
    }

    /**
     * @return string|null
     */
    public function getCommentBody(): ?string
    {
        return $this->comment_body;
    }

    /**
     * @param string|null $comment_body
     */
    public function setCommentBody(?string $comment_body): void
    {
        $this->comment_body = $comment_body;
    }
}