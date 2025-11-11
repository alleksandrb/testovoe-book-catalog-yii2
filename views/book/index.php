<?php

declare(strict_types=1);

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Books';
?>
<div class="book-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <p>
        Показано <?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?> книг
    </p>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Year</th>
                    <th>ISBN</th>
                    <th>Authors</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $book): ?>
                    <tr>
                        <td><?= $book->id ?></td>
                        <td><?= Html::encode($book->title) ?></td>
                        <td><?= $book->year ?></td>
                        <td><?= Html::encode($book->isbn) ?></td>
                        <td>
                            <?php
                            $authorNames = array_map(function($author) {
                                return Html::encode($author->full_name);
                            }, $book->authors);
                            echo implode(', ', $authorNames);
                            ?>
                        </td>
                        <td>
                            <?= Html::a('View', ['view', 'id' => $book->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <?= Html::a('Update', ['update', 'id' => $book->id], ['class' => 'btn btn-sm btn-warning']) ?>
                                <?= Html::a('Delete', ['delete', 'id' => $book->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this book?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'options' => ['class' => 'pagination justify-content-center'],
    ]) ?>
</div>

