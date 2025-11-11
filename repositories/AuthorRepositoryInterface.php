<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Author;
use yii\db\ActiveQuery;

interface AuthorRepositoryInterface
{
    public function findById(int $id): ?Author;
    public function findAll(): array;
    public function getQuery(): ActiveQuery;
    public function save(Author $author): bool;
    public function delete(Author $author): bool;
}

