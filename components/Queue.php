<?php

declare(strict_types=1);

namespace app\components;

use app\models\QueueJob;
use yii\base\Component;

class Queue extends Component implements QueueInterface
{
    public function push(string $jobClass, array $jobData): int
    {
        $job = new QueueJob();
        $job->job_class = $jobClass;
        $job->job_data = json_encode($jobData, JSON_UNESCAPED_UNICODE);
        $job->status = 'pending';
        $job->attempts = 0;
        $job->created_at = time();

        if (!$job->save()) {
            throw new \RuntimeException('Failed to push job to queue: ' . json_encode($job->errors));
        }

        return $job->id;
    }
}

