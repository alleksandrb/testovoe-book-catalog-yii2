<?php

declare(strict_types=1);

namespace app\factories;

use app\dto\CreateBookDto;
use app\dto\UpdateBookDto;
use app\models\Book;
use yii\web\UploadedFile;

class BookDtoFactory
{
    public static function createCreateDto(array $postData, ?Book $book = null): CreateBookDto
    {
        // Get data from ActiveForm format ['Book' => [...]] or direct format
        $bookData = $postData['Book'] ?? $postData;
        
        // Validate required fields
        self::validateBookData($bookData);
        
        $title = (string)($bookData['title'] ?? '');
        $year = (int)($bookData['year'] ?? 0);
        $isbn = (string)($bookData['isbn'] ?? '');
        $description = isset($bookData['description']) && $bookData['description'] !== '' 
            ? (string)$bookData['description'] 
            : null;
        
        // Get authorIds from postData
        $authorIds = $postData['authorIds'] ?? [];
        if (!is_array($authorIds)) {
            $authorIds = [];
        }
        
        // Get uploaded file
        $tempBook = $book ?? new Book();
        $coverFile = UploadedFile::getInstance($tempBook, 'coverFile');
        
        return new CreateBookDto(
            $title,
            $year,
            $isbn,
            $description,
            $coverFile,
            $authorIds
        );
    }

    public static function createUpdateDto(array $postData, Book $book): UpdateBookDto
    {
        // Get data from ActiveForm format ['Book' => [...]] or direct format
        $bookData = $postData['Book'] ?? $postData;
        
        // Validate required fields
        self::validateBookData($bookData);
        
        $title = (string)($bookData['title'] ?? '');
        $year = (int)($bookData['year'] ?? 0);
        $isbn = (string)($bookData['isbn'] ?? '');
        $description = isset($bookData['description']) && $bookData['description'] !== '' 
            ? (string)$bookData['description'] 
            : null;
        
        // Get authorIds from postData
        $authorIds = $postData['authorIds'] ?? [];
        if (!is_array($authorIds)) {
            $authorIds = [];
        }
        
        // Get uploaded file
        $coverFile = UploadedFile::getInstance($book, 'coverFile');
        
        return new UpdateBookDto(
            $title,
            $year,
            $isbn,
            $description,
            $coverFile,
            $authorIds
        );
    }

    private static function validateBookData(array $bookData): void
    {
        $errors = [];
        
        if (empty($bookData['title'])) {
            $errors[] = 'Title is required';
        }
        
        if (empty($bookData['year'])) {
            $errors[] = 'Year is required';
        } elseif (!is_numeric($bookData['year'])) {
            $errors[] = 'Year must be a number';
        }
        
        if (empty($bookData['isbn'])) {
            $errors[] = 'ISBN is required';
        }
        
        if (!empty($errors)) {
            throw new \InvalidArgumentException('Validation failed: ' . implode(', ', $errors));
        }
    }
}

