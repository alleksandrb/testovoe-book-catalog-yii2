<?php

declare(strict_types=1);

namespace app\services;

use app\repositories\ReportRepositoryInterface;

class ReportService implements ReportServiceInterface
{
    private ReportRepositoryInterface $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getTopAuthorsByYear(int $year, int $limit = 10): array
    {
        return $this->reportRepository->getTopAuthorsByYear($year, $limit);
    }
}

