<?php

require_once __DIR__ . '/bootstrap.php';

// Core
use Doctrine\ORM\EntityManagerInterface;

// DTO Mapper
use App\DTOMapper\NewsDTOToNews;

// Include the News Service
use App\Service\NewsService;

// Include Utility functions
use App\Utility\Utils as U;

// Check if $entityManager is a valid instance of EntityManagerInterface; throw an error if not
if (!$entityManager instanceof EntityManagerInterface) {
    throw new \Exception('entityManager is not a valid EntityManagerInterface', 500);
}

// Instantiate News Service
$newsDTO = new NewsDTOToNews();
$newsService = new NewsService($entityManager, $newsDTO);

// Get and Display News entries
foreach ($newsService->getAll() as $news) {
    echo (U::displayNewsItem($news));
    foreach ($news->getComments() as $comment) {
        echo (U::displayCommentItem($comment));
    }
}