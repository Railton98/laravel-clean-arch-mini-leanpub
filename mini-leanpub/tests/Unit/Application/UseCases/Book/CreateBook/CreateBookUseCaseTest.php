<?php

namespace Tests\Minileanpub\Unit\Application\UseCases\Book\CreateBook;

use stdClass;
use App\Models\Book;
use PHPUnit\Framework\TestCase;
use MiniLeanpub\Domain\Book\Repository\BookRepositoryInterface;
use MiniLeanpub\Infrastructure\Repository\Book\BookEloquentRepository;
use MiniLeanpub\Application\UseCases\Book\CreateBook\CreateBookUseCase;
use MiniLeanpub\Application\UseCases\Book\CreateBook\DTO\{BookCreateInputDTO, BookCreateOutputDTO};

class CreateBookUseCaseTest extends TestCase
{
    public function testShouldCreateANewBookViaUseCase()
    {
        /** @var BookRepositoryInterface $repository */
        $repository = $this->getRepositoryMock();

        $input = new BookCreateInputDTO(
            '795be8dd-1908-4295-a535-e4dfd5247886',
            'My Awesome Book',
            'My Awesome Book Desc',
            25.9,
            'book_path',
            'text/markdown'
        );

        $useCase = new CreateBookUseCase($input, $repository);
        $result = $useCase->handle();

        $this->assertInstanceOf(BookCreateOutputDTO::class, $result);

        $data = $result->getData();

        $this->assertEquals('795be8dd-1908-4295-a535-e4dfd5247886', $data['id']);
        $this->assertEquals('My Awesome Book', $data['title']);
    }

    private function getRepositoryMock()
    {
        $return = new stdClass();
        $return->id = '795be8dd-1908-4295-a535-e4dfd5247886';
        $return->title = 'My Awesome Book';
        $return->description = 'My Awesome Book Desc';
        $return->price = 25.9;
        $return->book_path = 'book_path';

        $model = $this->createMock(Book::class); // Eloquent Book Model...

        $mock = $this->getMockBuilder(BookEloquentRepository::class)
            ->onlyMethods(['create'])
            ->setConstructorArgs([$model])
            ->getMock();

        $mock->expects($this->once())
            ->method('create')
            ->willReturn($return);

        return $mock;
    }
}
