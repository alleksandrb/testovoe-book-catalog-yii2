<?php

declare(strict_types=1);

namespace app\repositories;

use app\models\Subscription;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function findByAuthorAndPhone(int $authorId, string $phone): ?Subscription
    {
        return Subscription::findOne(['author_id' => $authorId, 'phone' => $phone]);
    }

    public function findByAuthorId(int $authorId): array
    {
        return Subscription::find()
            ->where(['author_id' => $authorId])
            ->all();
    }

    public function save(Subscription $subscription): bool
    {
        return $subscription->save(false);
    }

    public function delete(Subscription $subscription): bool
    {
        return $subscription->delete() !== false;
    }
}

