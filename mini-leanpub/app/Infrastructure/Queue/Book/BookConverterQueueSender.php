<?php

namespace MiniLeanpub\Infrastructure\Queue\Book;

use MiniLeanpub\Domain\Shared\Queue\QueueInterface;

class BookConverterQueueSender implements QueueInterface
{
    public function __construct(private string $bookPath)
    {
    }

    public function sendToQueue(): bool
    {
        ConvertBookJob::dispatch($this->bookPath);

        return true;
    }
}
