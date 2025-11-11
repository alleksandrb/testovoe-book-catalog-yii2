<?php

declare(strict_types=1);

namespace app\repositories;

interface ReportRepositoryInterface
{
    public function getTopAuthorsByYear(int $year, int $limit = 10): array;
}

