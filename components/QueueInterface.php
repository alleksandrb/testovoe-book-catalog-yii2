<?php

declare(strict_types=1);

namespace app\components;

interface QueueInterface
{
    public function push(string $jobClass, array $jobData): int;
}

