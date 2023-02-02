<?php

namespace MiniLeanpub\Domain\Shared\Queue;

interface QueueInterface
{
    public function sendToQueue(string $bookCode);
}
