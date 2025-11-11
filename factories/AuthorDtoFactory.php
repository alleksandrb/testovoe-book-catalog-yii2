<?php

declare(strict_types=1);

namespace app\factories;

use app\dto\CreateAuthorDto;
use app\dto\UpdateAuthorDto;
use app\models\Author;

class AuthorDtoFactory
{
    public static function createCreateDto(array $postData, ?Author $author = null): CreateAuthorDto
    {
        // Get data from ActiveForm format ['Author' => [...]] or direct format
        $authorData = $postData['Author'] ?? $postData;
        
        // Validate required fields
        self::validateAuthorData($authorData);
        
        $fullName = (string)($authorData['full_name'] ?? '');
        
        return new CreateAuthorDto($fullName);
    }

    public static function createUpdateDto(array $postData, Author $author): UpdateAuthorDto
    {
        // Get data from ActiveForm format ['Author' => [...]] or direct format
        $authorData = $postData['Author'] ?? $postData;
        
        // Validate required fields
        self::validateAuthorData($authorData);
        
        $fullName = (string)($authorData['full_name'] ?? '');
        
        return new UpdateAuthorDto($fullName);
    }

    private static function validateAuthorData(array $authorData): void
    {
        $errors = [];
        
        if (empty($authorData['full_name'])) {
            $errors[] = 'Full name is required';
        }
        
        if (!empty($errors)) {
            throw new \InvalidArgumentException('Validation failed: ' . implode(', ', $errors));
        }
    }
}

