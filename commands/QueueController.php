<?php

declare(strict_types=1);

namespace app\commands;

use app\models\QueueJob;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class QueueController extends Controller
{
    public function actionWork(): int
    {
        $this->stdout("Queue worker started...\n");

        while (true) {
            $job = QueueJob::find()
                ->where(['status' => QueueJob::STATUS_PENDING])
                ->orderBy(['created_at' => SORT_ASC])
                ->one();

            if (!$job) {
                sleep(1);
                continue;
            }

            $this->processJob($job);
        }
    }

    private function processJob(QueueJob $job): void
    {
        $job->status = QueueJob::STATUS_PROCESSING;
        $job->started_at = time();
        $job->attempts++;
        $job->save(false);

        try {
            $jobData = $job->getJobData();
            $jobClass = $job->job_class;

            if (!class_exists($jobClass)) {
                throw new \RuntimeException("Job class {$jobClass} not found");
            }

            if (!method_exists($jobClass, 'execute')) {
                throw new \RuntimeException("Job class {$jobClass} does not have execute method");
            }

            call_user_func_array([$jobClass, 'execute'], $jobData);

            $job->status = QueueJob::STATUS_COMPLETED;
            $job->finished_at = time();
            $job->save(false);

            $this->stdout("Job #{$job->id} completed successfully\n");
        } catch (\Throwable $e) {
            $job->status = QueueJob::STATUS_FAILED;
            $job->finished_at = time();
            $job->error = $e->getMessage();
            $job->save(false);

            $this->stderr("Job #{$job->id} failed: {$e->getMessage()}\n");
        }
    }
}

