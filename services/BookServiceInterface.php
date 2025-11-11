<?php

declare(strict_types=1);

namespace app\services;

use app\dto\CreateBookDto;
use app\dto\UpdateBookDto;
use app\models\Book;
use yii\data\ActiveDataProvider;

interface BookServiceInterface
{
    public function getBookById(int $id): ?Book;
    public function getAllBooks(): array;
    public function getBooksDataProvider(int $pageSize = 10): ActiveDataProvider;
    public function createBook(CreateBookDto $dto): Book;
    public function updateBook(Book $book, UpdateBookDto $dto): Book;
    public function deleteBook(Book $book): bool;
}

