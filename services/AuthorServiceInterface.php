<?php

declare(strict_types=1);

namespace app\services;

use app\dto\CreateAuthorDto;
use app\dto\UpdateAuthorDto;
use app\models\Author;
use yii\data\ActiveDataProvider;

interface AuthorServiceInterface
{
    public function getAuthorById(int $id): ?Author;
    public function getAllAuthors(): array;
    public function getAuthorsDataProvider(int $pageSize = 10): ActiveDataProvider;
    public function createAuthor(CreateAuthorDto $dto): Author;
    public function updateAuthor(Author $author, UpdateAuthorDto $dto): Author;
    public function deleteAuthor(Author $author): bool;
}

