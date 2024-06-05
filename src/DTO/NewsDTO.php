<?php

namespace App\DTO;

class NewsDTO
{
    private ?string $title;
    private ?string $body;

    /**
     * @param string|null $title
     * @param string|null $body
     */
    public function __construct(?string $title, ?string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
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
    public function setBody(?string $body): void
    {
        $this->body = $body;
    }
}