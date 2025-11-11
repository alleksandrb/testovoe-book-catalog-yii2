<?php

declare(strict_types=1);

namespace app\controllers;

use app\services\SubscriptionServiceInterface;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SubscriptionController extends Controller
{
    private SubscriptionServiceInterface $subscriptionService;

    public function __construct($id, $module, SubscriptionServiceInterface $subscriptionService, $config = [])
    {
        $this->subscriptionService = $subscriptionService;
        parent::__construct($id, $module, $config);
    }

    public function actionSubscribe(int $authorId): Response
    {
        $request = Yii::$app->request;
        $phone = $request->post('phone', '');
        $userId = Yii::$app->user->isGuest ? null : Yii::$app->user->id;

        if (empty($phone)) {
            Yii::$app->session->setFlash('error', 'Phone number is required');
            return $this->redirect(['author/view', 'id' => $authorId]);
        }

        try {
            $this->subscriptionService->subscribe($authorId, $phone, $userId);
            Yii::$app->session->setFlash('success', 'Successfully subscribed');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['author/view', 'id' => $authorId]);
    }

    public function actionUnsubscribe(int $authorId): Response
    {
        $request = Yii::$app->request;
        $phone = $request->post('phone', '');

        if (empty($phone)) {
            Yii::$app->session->setFlash('error', 'Phone number is required');
            return $this->redirect(['author/view', 'id' => $authorId]);
        }

        try {
            $this->subscriptionService->unsubscribe($authorId, $phone);
            Yii::$app->session->setFlash('success', 'Successfully unsubscribed');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['author/view', 'id' => $authorId]);
    }
}

