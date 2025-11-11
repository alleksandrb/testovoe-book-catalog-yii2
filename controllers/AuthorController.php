<?php

declare(strict_types=1);

namespace app\controllers;

use app\factories\AuthorDtoFactory;
use app\services\AuthorServiceInterface;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AuthorController extends Controller
{
    private AuthorServiceInterface $authorService;

    public function __construct($id, $module, AuthorServiceInterface $authorService, $config = [])
    {
        $this->authorService = $authorService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['?', '@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        $dataProvider = $this->authorService->getAuthorsDataProvider(10);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id): string
    {
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            throw new NotFoundHttpException('Author not found');
        }

        return $this->render('view', [
            'author' => $author,
        ]);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            try {
                $postData = $request->post();
                $dto = AuthorDtoFactory::createCreateDto($postData);
                $author = $this->authorService->createAuthor($dto);
                return $this->redirect(['view', 'id' => $author->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $author = new \app\models\Author();
        return $this->render('create', ['author' => $author]);
    }

    public function actionUpdate(int $id)
    {
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            throw new NotFoundHttpException('Author not found');
        }

        $request = Yii::$app->request;
        
        if ($request->isPost) {
            try {
                $postData = $request->post();
                $dto = AuthorDtoFactory::createUpdateDto($postData, $author);
                $author = $this->authorService->updateAuthor($author, $dto);
                return $this->redirect(['view', 'id' => $author->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'author' => $author,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            throw new NotFoundHttpException('Author not found');
        }

        try {
            $this->authorService->deleteAuthor($author);
            Yii::$app->session->setFlash('success', 'Author deleted successfully');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }
}

