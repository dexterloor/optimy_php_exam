<?php

namespace App\DTOMapper;

// DTO
use App\DTO\NewsDTO;

// Entity
use App\Entity\News;

class NewsDTOToNews
{
    public function map(NewsDTO $newsDTO): ?News
    {
        // Create News Object from News DTO
        $news = new News();
        $news->setTitle($newsDTO->getTitle());
        $news->setBody($newsDTO->getBody());

        // Set Created Date to Now
        $now = new \DateTime();
        $news->setCreatedAt($now->format('Y-m-d H:i:s'));

        return $news;
    }
}