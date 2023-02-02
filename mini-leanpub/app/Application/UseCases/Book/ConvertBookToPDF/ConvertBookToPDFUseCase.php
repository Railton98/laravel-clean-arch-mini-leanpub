<?php

namespace MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF;

use MiniLeanpub\Domain\Shared\Queue\QueueInterface;
use MiniLeanpub\Domain\Book\Repository\BookRepositoryInterface;
use MiniLeanpub\Application\UseCases\Book\ConvertBookToPDF\DTO\{
    ConvertBookToPDFInputDTO,
    ConvertBookToPDFOutputDTO
};

class ConvertBookToPDFUseCase
{
    public function __construct(
        private ConvertBookToPDFInputDTO $input,
        private BookRepositoryInterface $repository,
        private QueueInterface $queue
    ) {
    }

    public function handle(): ConvertBookToPDFOutputDTO
    {
        $book = $this->repository->find($this->input->getData()['bookCode']);

        $this->queue->sendToQueue($book->book_code);

        return new ConvertBookToPDFOutputDTO($book->book_code);
    }
}
