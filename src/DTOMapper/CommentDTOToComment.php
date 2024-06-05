<?php

namespace App\DTOMapper;

// DTO
use App\DTO\CommentDTO;

// Entity
use App\Entity\Comment;

// News Service
use App\Service\NewsService;

class CommentDTOToComment
{
    public function map(NewsService $newsService, CommentDTO $commentDTO)
    {
        // Get News from NewsService
        $news = $newsService->getById($commentDTO->getNewsId());

        // Create Comment Object
        $comment = new Comment();
        $comment->setNews($news);
        $comment->setBody($commentDTO->getCommentBody());

        // Set Created Date to Now
        $now = new \DateTime();
        $comment->setCreatedAt($now->format('Y-m-d H:i:s'));

        return $comment;
    }
}