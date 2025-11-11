<?php

declare(strict_types=1);

use app\components\Queue;
use app\components\QueueInterface;
use app\components\SmsSenderInterface;
use app\components\SmspilotSender;
use app\repositories\AuthorRepository;
use app\repositories\AuthorRepositoryInterface;
use app\repositories\BookRepository;
use app\repositories\BookRepositoryInterface;
use app\repositories\ReportRepository;
use app\repositories\ReportRepositoryInterface;
use app\repositories\SubscriptionRepository;
use app\repositories\SubscriptionRepositoryInterface;
use app\services\AuthorService;
use app\services\AuthorServiceInterface;
use app\services\BookService;
use app\services\BookServiceInterface;
use app\services\NotificationServiceInterface;
use app\services\ReportService;
use app\services\ReportServiceInterface;
use app\services\SmsNotificationService;
use app\services\SubscriptionService;
use app\services\SubscriptionServiceInterface;
use yii\di\Container;

$container = Yii::$container;

// Repositories
$container->setSingleton(BookRepositoryInterface::class, BookRepository::class);
$container->setSingleton(AuthorRepositoryInterface::class, AuthorRepository::class);
$container->setSingleton(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
$container->setSingleton(ReportRepositoryInterface::class, ReportRepository::class);

// SMS Component
$container->setSingleton(SmsSenderInterface::class, function () {
    $params = Yii::$app->params;
    return new SmspilotSender(
        $params['smspilot']['apiKey'],
        $params['smspilot']['apiUrl']
    );
});

// Notification Service
$container->setSingleton(NotificationServiceInterface::class, SmsNotificationService::class);

// Queue Component
$container->setSingleton(QueueInterface::class, Queue::class);

// Services
$container->setSingleton(BookServiceInterface::class, BookService::class);
$container->set(BookService::class, function (Container $container) {
    return new BookService(
        $container->get(BookRepositoryInterface::class),
        $container->get(AuthorRepositoryInterface::class)
    );
});

$container->setSingleton(AuthorServiceInterface::class, AuthorService::class);
$container->set(AuthorService::class, function (Container $container) {
    return new AuthorService(
        $container->get(AuthorRepositoryInterface::class)
    );
});

$container->setSingleton(SubscriptionServiceInterface::class, SubscriptionService::class);
$container->set(SubscriptionService::class, function (Container $container) {
    return new SubscriptionService(
        $container->get(SubscriptionRepositoryInterface::class),
        $container->get(AuthorRepositoryInterface::class),
        $container->get(NotificationServiceInterface::class)
    );
});

$container->setSingleton(ReportServiceInterface::class, ReportService::class);
$container->set(ReportService::class, function (Container $container) {
    return new ReportService(
        $container->get(ReportRepositoryInterface::class)
    );
});

