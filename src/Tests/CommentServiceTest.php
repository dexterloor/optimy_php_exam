<?php

namespace App\Tests;

// Core
use App\Service\NewsService;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

// DTO
use App\DTO\CommentDTO;

// DTO Mapper
use App\DTOMapper\CommentDTOToComment;
use App\DTOMapper\NewsDTOToNews;

// Entity
use App\Entity\Comment;

// Service
use App\Service\CommentService;

class CommentServiceTest extends TestCase
{
    private ?EntityManagerInterface $entityManager;
    private ?CommentService $commentService;
    private ?CommentDTOToComment $commentDTOToComment;
    private ?NewsDTOToNews $newsDTOToNews;
    private ?NewsService $newsService;
    protected function setUp(): void
    {
        // Mock EntityManagerInterface
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        // Instantiate NewsService — which is used in the CommentDTO Mapper including required parameters
        $this->newsDTOToNews = $this->createMock(NewsDTOToNews::class);
        $this->newsService = new NewsService($this->entityManager, $this->newsDTOToNews);

        // Mock CommentDTO Mapper Class
        $this->commentDTOToComment = $this->createMock(CommentDTOToComment::class);

        // Instantiate CommentService — the Class to test
        $this->commentService = new CommentService($this->entityManager, $this->commentDTOToComment, $this->newsService);
    }

    protected function tearDown(): void
    {
        $this->entityManager = null;
        $this->commentDTOToComment = null;
        $this->commentService = null;
    }

    public function testGetAll()
    {
        $expected = [new Comment(), new Comment()];

        // Mock the EntityRepository and the findAll method to be used with the getAll method
        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn($expected);

        // Test the getRepository and expect that it will return the mocked EntityRepository
        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Comment::class)
            ->willReturn($repository);

        // Call the service method and assert the result
        $result = $this->commentService->getAll();
        $this->assertCount(2, $result);
    }

    public function testGetById()
    {
        $expected = new Comment();

        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($expected);

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(Comment::class)
            ->willReturn($repository);

        $result = $this->commentService->getById(1);
        $this->assertSame($expected, $result);
    }

    public function testCreateOne()
    {
        $commentDTO = $this->createMock(CommentDTO::class);
        $comment = $this->createMock(Comment::class);

        $this->commentDTOToComment->expects($this->once())
            ->method('map')
            ->with($this->newsService, $commentDTO)
            ->willReturn($comment);

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($comment);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $result = $this->commentService->createOne($commentDTO);

        $this->assertSame($comment, $result);
    }

    public function testDeleteComment()
    {
        $comment = $this->createMock(Comment::class);

        // Mock the getId method to return the expected ID
        $comment->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        // Mock getById method to return news object
        $this->commentService = $this->getMockBuilder(CommentService::class)
            ->setConstructorArgs([$this->entityManager, $this->commentDTOToComment, $this->newsService])
            ->onlyMethods(['getById'])
            ->getMock();

        $this->commentService->expects($this->once())
            ->method('getById')
            ->with($comment->getId())
            ->willReturn($comment);

        // Call deleteNews method
        $this->commentService->deleteComment(1);

        // Assert that news array will only be left with 1 entry
        $this->assertNotNull($comment, 'Comment was not removed');
    }
}