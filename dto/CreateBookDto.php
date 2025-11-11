<?php

declare(strict_types=1);

namespace app\dto;

use yii\web\UploadedFile;

class CreateBookDto
{
    public string $title;
    public int $year;
    public string $isbn;
    public ?string $description;
    public ?UploadedFile $coverFile;
    public array $authorIds;

    public function __construct(
        string $title,
        int $year,
        string $isbn,
        ?string $description,
        ?UploadedFile $coverFile,
        array $authorIds
    ) {
        $this->title = $title;
        $this->year = $year;
        $this->isbn = $isbn;
        $this->description = $description;
        $this->coverFile = $coverFile;
        $this->authorIds = $authorIds;
    }
}

