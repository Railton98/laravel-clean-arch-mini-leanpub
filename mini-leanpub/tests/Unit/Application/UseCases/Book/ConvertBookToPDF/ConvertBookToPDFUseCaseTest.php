<?php

namespace Tests\Minileanpub\Unit\Application\UseCases\Book\ConvertBookToPdf;

use PHPUnit\Framework\TestCase;

class ConvertBookToPDFUseCaseTest extends TestCase
{
    public function testShouldSendABookToConvertToPdfViaUseCase()
    {
        $input = new ConvertBookToPDFInputDTO('72479eaa-62a8-4ddb-8d6e-4c35c6c7f700');
        $repository = $this->getRepositoryMock();
        $queueSender  = $this->getQueueSenderMock();

        $useCase = new ConvertBookToPDFUseCase($input, $repository, $queueSender);
        $result = $useCase->handle();

        $this->assertInstanceOf(ConvertBookToPDFOutputDTO::class, $result);
    }

    private function getRepositoryMock()
    {
        $stubModel = $this->createMock(Book::class);

        $return = new \stdClass();
        $return->id = 1;
        $return->book_code = '72479eaa-62a8-4ddb-8d6e-4c35c6c7f700';
        $return->title = 'My awesome book title!';
        $return->description = 'Book Description';
        $return->price = 25.9;
        $return->book_path = 'book_path';


        $mock = $this->getMockBuilder(BookEloquentRepository::class)
            ->onlyMethods(['find'])
            ->setConstructorArgs([$stubModel])
            ->getMock();

        $mock->expects($this->once())
            ->method('find')
            ->with('72479eaa-62a8-4ddb-8d6e-4c35c6c7f700')
            ->willReturn($return);

        return $mock;
    }

    private function getQueueSenderMock()
    {
        $mock = $this->getMockBuilder(BookConverterQueueSender::class)
            ->onlyMethods(['sendToQueue'])
            ->getMock();

        $mock->expects($this->once())
            ->method('sendToQueue')
            ->willReturn(true);

        return $mock;
    }
}
