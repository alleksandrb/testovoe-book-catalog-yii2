<?php

declare(strict_types=1);

namespace app\controllers;

use app\services\ReportServiceInterface;
use Yii;
use yii\web\Controller;

class ReportController extends Controller
{
    private ReportServiceInterface $reportService;

    public function __construct($id, $module, ReportServiceInterface $reportService, $config = [])
    {
        $this->reportService = $reportService;
        parent::__construct($id, $module, $config);
    }

    public function actionTopAuthors(): string
    {
        $request = Yii::$app->request;
        $year = (int)$request->get('year', date('Y'));
        $limit = (int)$request->get('limit', 10);

        $topAuthors = $this->reportService->getTopAuthorsByYear($year, $limit);

        return $this->render('top-authors', [
            'topAuthors' => $topAuthors,
            'year' => $year,
        ]);
    }
}

