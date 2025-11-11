<?php

declare(strict_types=1);

namespace app\services;

use app\dto\CreateBookDto;
use app\dto\UpdateBookDto;
use app\models\Book;
use app\models\BookAuthor;
use app\repositories\BookRepositoryInterface;
use app\repositories\AuthorRepositoryInterface;
use yii\data\ActiveDataProvider;

class BookService implements BookServiceInterface
{
    private BookRepositoryInterface $bookRepository;
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(
        BookRepositoryInterface $bookRepository,
        AuthorRepositoryInterface $authorRepository
    ) {
        $this->bookRepository = $bookRepository;
        $this->authorRepository = $authorRepository;
    }

    public function getBookById(int $id): ?Book
    {
        return $this->bookRepository->findById($id);
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->findAll();
    }

    public function getBooksDataProvider(int $pageSize = 10): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $this->bookRepository->getQuery()->with('authors'),
            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);
    }

    public function createBook(CreateBookDto $dto): Book
    {
        $book = new Book();
        $book->title = $dto->title;
        $book->year = $dto->year;
        $book->isbn = $dto->isbn;
        $book->description = $dto->description;
        
        if ($dto->coverFile) {
            $book->coverFile = $dto->coverFile;
        }

        if (!$book->validate()) {
            throw new \Exception('Validation failed: ' . json_encode($book->errors));
        }

        if (!$this->bookRepository->save($book)) {
            throw new \Exception('Failed to save book');
        }

        $this->attachAuthors($book, $dto->authorIds);

        return $book;
    }

    public function updateBook(Book $book, UpdateBookDto $dto): Book
    {
        $book->title = $dto->title;
        $book->year = $dto->year;
        $book->isbn = $dto->isbn;
        $book->description = $dto->description;
        
        if ($dto->coverFile) {
            $book->coverFile = $dto->coverFile;
        }

        if (!$book->validate()) {
            throw new \Exception('Validation failed: ' . json_encode($book->errors));
        }

        if (!$this->bookRepository->save($book)) {
            throw new \Exception('Failed to save book');
        }

        $this->attachAuthors($book, $dto->authorIds);

        return $book;
    }

    public function deleteBook(Book $book): bool
    {
        BookAuthor::deleteAll(['book_id' => $book->id]);
        
        if (!$this->bookRepository->delete($book)) {
            throw new \Exception('Failed to delete book');
        }

        return true;
    }

    private function attachAuthors(Book $book, array $authorIds): void
    {
        BookAuthor::deleteAll(['book_id' => $book->id]);

        foreach ($authorIds as $authorId) {
            $author = $this->authorRepository->findById((int)$authorId);
            if ($author) {
                $bookAuthor = new BookAuthor();
                $bookAuthor->book_id = $book->id;
                $bookAuthor->author_id = $author->id;
                $bookAuthor->save(false);
            }
        }
    }
}

