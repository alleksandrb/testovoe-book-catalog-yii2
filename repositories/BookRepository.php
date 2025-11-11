<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Book;
use yii\db\ActiveQuery;

class BookRepository implements BookRepositoryInterface
{
    public function findById(int $id): ?Book
    {
        return Book::findOne($id);
    }

    public function findAll(): array
    {
        return Book::find()->with('authors')->all();
    }

    public function getQuery(): ActiveQuery
    {
        return Book::find();
    }

    public function save(Book $book): bool
    {
        return $book->save(false);
    }

    public function delete(Book $book): bool
    {
        return $book->delete() !== false;
    }

    public function findByAuthorId(int $authorId): array
    {
        return Book::find()
            ->innerJoinWith('authors')
            ->where(['{{%authors}}.id' => $authorId])
            ->all();
    }
}

