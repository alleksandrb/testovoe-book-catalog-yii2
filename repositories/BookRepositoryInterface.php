<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Book;
use yii\db\ActiveQuery;

interface BookRepositoryInterface
{
    public function findById(int $id): ?Book;
    public function findAll(): array;
    public function getQuery(): ActiveQuery;
    public function save(Book $book): bool;
    public function delete(Book $book): bool;
    public function findByAuthorId(int $authorId): array;
}

