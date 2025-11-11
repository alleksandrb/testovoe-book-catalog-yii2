<?php

declare(strict_types=1);

namespace app\services;

interface NotificationServiceInterface
{
    public function sendSms(string $phone, string $message): bool;
}

