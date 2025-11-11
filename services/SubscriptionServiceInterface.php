<?php

declare(strict_types=1);

namespace app\services;

use app\models\Subscription;

interface SubscriptionServiceInterface
{
    public function subscribe(int $authorId, string $phone, ?int $userId = null): Subscription;
    public function unsubscribe(int $authorId, string $phone): bool;
    public function notifySubscribers(int $authorId, string $bookTitle): int;
}

