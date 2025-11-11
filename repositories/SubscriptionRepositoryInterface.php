<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Subscription;

interface SubscriptionRepositoryInterface
{
    public function findByAuthorAndPhone(int $authorId, string $phone): ?Subscription;
    public function findByAuthorId(int $authorId): array;
    public function save(Subscription $subscription): bool;
    public function delete(Subscription $subscription): bool;
}

