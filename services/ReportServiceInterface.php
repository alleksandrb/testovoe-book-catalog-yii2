<?php

declare(strict_types=1);

namespace app\services;

interface ReportServiceInterface
{
    public function getTopAuthorsByYear(int $year, int $limit = 10): array;
}

