<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

// Data Transfer Object (DTO) Mapper
use App\DTO\NewsDTO;
use App\DTOMapper\NewsDTOToNews;

// Entity
use App\Entity\News;

class NewsService
{
    private EntityManagerInterface $entityManager;
    private NewsDTOToNews $newsDTOToNews;

    /**
     * @param EntityManagerInterface $entityManager
     * @param NewsDTOToNews $newsDTOToNews
     */
    public function __construct(EntityManagerInterface $entityManager, NewsDTOToNews $newsDTOToNews)
    {
        $this->entityManager = $entityManager;
        $this->newsDTOToNews = $newsDTOToNews;
    }

    public function getAll(): array
    {
        return $this->entityManager->getRepository(News::class)->findAll();
    }

    public function getById($id): ?News
    {
        return $this->entityManager->getRepository(News::class)->find($id);
    }

    public function createOne(NewsDTO $newsDTO): ?News
    {
        $news = $this->newsDTOToNews->map($newsDTO);
        $this->entityManager->persist($news);
        $this->entityManager->flush();

        return $news;
    }

    public function deleteNews($id): void
    {
        $news = $this->getById($id);

        if (!is_null($news)) {
            foreach ($news->getComments() as $comment) {
                $news->removeComment($comment);
                $this->entityManager->remove($comment);
            }

            $this->entityManager->remove($news);
            $this->entityManager->flush();
        } else {
            throw new \Exception('No News found for given ID', 500);
        }
    }
}