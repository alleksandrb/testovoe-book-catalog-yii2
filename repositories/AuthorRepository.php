<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Author;
use yii\db\ActiveQuery;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function findById(int $id): ?Author
    {
        return Author::findOne($id);
    }

    public function findAll(): array
    {
        return Author::find()->all();
    }

    public function getQuery(): ActiveQuery
    {
        return Author::find();
    }

    public function save(Author $author): bool
    {
        return $author->save(false);
    }

    public function delete(Author $author): bool
    {
        return $author->delete() !== false;
    }
}

