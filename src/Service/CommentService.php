<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

// Data Transfer Object (DTO) Mapper
use App\DTO\CommentDTO;
use App\DTOMapper\CommentDTOToComment;

// Entity
use App\Entity\Comment;

// Service
use App\Service\NewsService;

class CommentService
{
    private ?EntityManagerInterface $entityManager;
    private ?CommentDTOToComment $commentDTOToComment;
    private ?NewsService $newsService;

    /**
     * @param EntityManagerInterface|null $entityManager
     * @param CommentDTOToComment|null $commentDTOToComment
     * @param \App\Service\NewsService|null $newsService
     */
    public function __construct(?EntityManagerInterface $entityManager, ?CommentDTOToComment $commentDTOToComment, ?\App\Service\NewsService $newsService)
    {
        $this->entityManager = $entityManager;
        $this->commentDTOToComment = $commentDTOToComment;
        $this->newsService = $newsService;
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(Comment::class)->findAll();
    }

    public function getById($id): ?Comment
    {
        return $this->entityManager->getRepository(Comment::class)->find($id);
    }

    public function createOne(CommentDTO $commentDTO): ?Comment
    {
        $comment = $this->commentDTOToComment->map($this->newsService, $commentDTO);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return $comment;
    }

    public function deleteComment($id): void
    {
        $comment = $this->getById($id);

        if (!is_null($comment)) {
            $this->entityManager->remove($comment);
            $this->entityManager->flush();
        } else {
            throw new \Exception('No Comment found for given ID', 500);
        }
    }
}