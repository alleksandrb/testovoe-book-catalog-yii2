<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\QueueInterface;
use app\factories\BookDtoFactory;
use app\jobs\NotifySubscribersJob;
use app\services\BookServiceInterface;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class BookController extends Controller
{
    private BookServiceInterface $bookService;
    private QueueInterface $queue;

    public function __construct(
        $id,
        $module,
        BookServiceInterface $bookService,
        QueueInterface $queue,
        $config = []
    ) {
        $this->bookService = $bookService;
        $this->queue = $queue;
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
        $dataProvider = $this->bookService->getBooksDataProvider(10);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id): string
    {
        $book = $this->bookService->getBookById($id);
        if (!$book) {
            throw new NotFoundHttpException('Book not found');
        }

        return $this->render('view', [
            'book' => $book,
        ]);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        
        if ($request->isPost) {
            try {
                $postData = $request->post();
                $dto = BookDtoFactory::createCreateDto($postData);
                $book = $this->bookService->createBook($dto);
                
                // Push notification jobs to queue
                foreach ($dto->authorIds as $authorId) {
                    $this->queue->push(NotifySubscribersJob::class, [
                        (int)$authorId,
                        $book->title,
                    ]);
                }
                
                return $this->redirect(['view', 'id' => $book->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        $book = new \app\models\Book();
        return $this->render('create', ['book' => $book]);
    }

    public function actionUpdate(int $id)
    {
        $book = $this->bookService->getBookById($id);
        if (!$book) {
            throw new NotFoundHttpException('Book not found');
        }

        $request = Yii::$app->request;
        
        if ($request->isPost) {
            try {
                $postData = $request->post();
                $dto = BookDtoFactory::createUpdateDto($postData, $book);
                $book = $this->bookService->updateBook($book, $dto);
                return $this->redirect(['view', 'id' => $book->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'book' => $book,
        ]);
    }

    public function actionDelete(int $id): Response
    {
        $book = $this->bookService->getBookById($id);
        if (!$book) {
            throw new NotFoundHttpException('Book not found');
        }

        try {
            $this->bookService->deleteBook($book);
            Yii::$app->session->setFlash('success', 'Book deleted successfully');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }
}

