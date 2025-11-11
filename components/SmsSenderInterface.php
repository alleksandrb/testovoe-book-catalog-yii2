<?php

declare(strict_types=1);

namespace app\components;

interface SmsSenderInterface
{
    public function send(string $phone, string $message): bool;
}

