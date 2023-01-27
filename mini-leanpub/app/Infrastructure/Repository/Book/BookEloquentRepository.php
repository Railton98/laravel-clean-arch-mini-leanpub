<?php

namespace MiniLeanpub\Infrastructure\Repository\Book;

use App\Models\Book;
use MiniLeanpub\Domain\Book\Repository\BookRepositoryInterface;

class BookEloquentRepository implements BookRepositoryInterface
{
    public function __construct(private Book $model)
    {
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
