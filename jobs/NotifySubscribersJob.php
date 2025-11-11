<?php

declare(strict_types=1);

namespace app\jobs;

use app\services\SubscriptionService;
use Yii;

class NotifySubscribersJob
{
    public static function execute(int $authorId, string $bookTitle): void
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = Yii::$container->get(SubscriptionService::class);
        $subscriptionService->notifySubscribers($authorId, $bookTitle);
    }
}

