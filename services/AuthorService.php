<?php

declare(strict_types=1);

namespace app\services;

use app\dto\CreateAuthorDto;
use app\dto\UpdateAuthorDto;
use app\models\Author;
use app\repositories\AuthorRepositoryInterface;
use yii\data\ActiveDataProvider;

class AuthorService implements AuthorServiceInterface
{
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function getAuthorById(int $id): ?Author
    {
        return $this->authorRepository->findById($id);
    }

    public function getAllAuthors(): array
    {
        return $this->authorRepository->findAll();
    }

    public function getAuthorsDataProvider(int $pageSize = 10): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $this->authorRepository->getQuery(),
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

    public function createAuthor(CreateAuthorDto $dto): Author
    {
        $author = new Author();
        $author->full_name = $dto->fullName;

        if (!$author->validate()) {
            throw new \Exception('Validation failed: ' . json_encode($author->errors));
        }

        if (!$this->authorRepository->save($author)) {
            throw new \Exception('Failed to save author');
        }

        return $author;
    }

    public function updateAuthor(Author $author, UpdateAuthorDto $dto): Author
    {
        $author->full_name = $dto->fullName;

        if (!$author->validate()) {
            throw new \Exception('Validation failed: ' . json_encode($author->errors));
        }

        if (!$this->authorRepository->save($author)) {
            throw new \Exception('Failed to save author');
        }

        return $author;
    }

    public function deleteAuthor(Author $author): bool
    {
        if (!$this->authorRepository->delete($author)) {
            throw new \Exception('Failed to delete author');
        }

        return true;
    }
}

