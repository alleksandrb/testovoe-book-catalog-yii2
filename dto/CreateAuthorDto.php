<?php

declare(strict_types=1);

namespace app\dto;

class CreateAuthorDto
{
    public string $fullName;

    public function __construct(string $fullName)
    {
        $this->fullName = $fullName;
    }
}

