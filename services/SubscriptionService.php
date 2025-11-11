<?php

declare(strict_types=1);

namespace app\services;

use app\models\Subscription;
use app\repositories\AuthorRepositoryInterface;
use app\repositories\SubscriptionRepositoryInterface;
use app\services\NotificationServiceInterface;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private AuthorRepositoryInterface $authorRepository,
        private NotificationServiceInterface $notificationService
    ) {}

    public function subscribe(int $authorId, string $phone, ?int $userId = null): Subscription
    {
        $author = $this->authorRepository->findById($authorId);
        if (!$author) {
            throw new \Exception('Author not found');
        }

        $existing = $this->subscriptionRepository->findByAuthorAndPhone($authorId, $phone);
        if ($existing) {
            throw new \Exception('Already subscribed');
        }

        $subscription = new Subscription();
        $subscription->author_id = $authorId;
        $subscription->phone = $phone;
        $subscription->user_id = $userId;

        if (!$subscription->validate()) {
            throw new \Exception('Validation failed: ' . json_encode($subscription->errors));
        }

        if (!$this->subscriptionRepository->save($subscription)) {
            throw new \Exception('Failed to save subscription');
        }

        return $subscription;
    }

    public function unsubscribe(int $authorId, string $phone): bool
    {
        $subscription = $this->subscriptionRepository->findByAuthorAndPhone($authorId, $phone);
        if (!$subscription) {
            throw new \Exception('Subscription not found');
        }

        if (!$this->subscriptionRepository->delete($subscription)) {
            throw new \Exception('Failed to delete subscription');
        }

        return true;
    }

    public function notifySubscribers(int $authorId, string $bookTitle): int
    {
        $subscriptions = $this->subscriptionRepository->findByAuthorId($authorId);
        $author = $this->authorRepository->findById($authorId);
        
        if (!$author) {
            return 0;
        }

        $message = "Новая книга автора {$author->full_name}: {$bookTitle}";
        $sentCount = 0;

        foreach ($subscriptions as $subscription) {
            if ($this->notificationService->sendSms($subscription->phone, $message)) {
                $sentCount++;
            }
        }

        return $sentCount;
    }
}

