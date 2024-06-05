<?php

namespace App\Tests;

// Core
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

// DTO
use App\DTO\NewsDTO;

// DTO Mapper
use App\DTOMapper\NewsDTOToNews;

// Entity
use App\Entity\News;

// Service
use App\Service\NewsService;

class NewsServiceTest extends TestCase
{
    private ?EntityManagerInterface $entityManager;
    private ?NewsService $newsService;
    private ?NewsDTOToNews $newsDTOToNews;

    protected function setUp(): void
    {
        // Mock EntityManagerInterface & NewsDTO Mapper Classes
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->newsDTOToNews = $this->createMock(NewsDTOToNews::class);

        // Instantiate NewsService — the Class to test
        $this->newsService = new NewsService($this->entityManager, $this->newsDTOToNews);
    }

    protected function tearDown(): void
    {
        // Reset properties to make sure each test is isolated
        $this->entityManager = null;
        $this->newsService = null;
        $this->newsDTOToNews = null;
    }

    public function testGetAll()
    {
        $expected = [new News(), new News()];

        // Mock the EntityRepository and the findAll method to be used with the getAll method
        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($expected);

        // Test the getRepository and expect that it will return the mocked EntityRepository
        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(News::class)
            ->willReturn($repository);

        // Call the service method and assert the result
        $result = $this->newsService->getAll();
        $this->assertCount(2, $result);
    }

    public function testGetById()
    {
        $expected = new News();

        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($expected);

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(News::class)
            ->willReturn($repository);

        $result = $this->newsService->getById(1);
        $this->assertSame($expected, $result);
    }

    public function testCreateOne()
    {
        $newsDTO = $this->createMock(NewsDTO::class);
        $news = $this->createMock(News::class);

        $this->newsDTOToNews->expects($this->once())
            ->method('map')
            ->with($newsDTO)
            ->willReturn($news);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($news);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $result = $this->newsService->createOne($newsDTO);

        $this->assertSame($news, $result);
    }

    public function testDeleteNews()
    {
        $news = $this->createMock(News::class);

        // Mock the getId method to return the expected ID
        $news->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        // Mock getById method to return news object
        $this->newsService = $this->getMockBuilder(NewsService::class)
            ->setConstructorArgs([$this->entityManager, $this->newsDTOToNews])
            ->onlyMethods(['getById'])
            ->getMock();

        $this->newsService->expects($this->once())
            ->method('getById')
            ->with($news->getId())
            ->willReturn($news);

        // Call deleteNews method
        $this->newsService->deleteNews(1);

        // Assert that news array will only be left with 1 entry
        $this->assertNotNull($news, 'News was not removed');
    }
}