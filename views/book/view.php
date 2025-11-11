<?php

declare(strict_types=1);

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Book $book */

$this->title = $book->title;
?>
<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Update', ['update', 'id' => $book->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $book->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this book?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <table class="table">
        <tr>
            <th>Title</th>
            <td><?= Html::encode($book->title) ?></td>
        </tr>
        <tr>
            <th>Year</th>
            <td><?= $book->year ?></td>
        </tr>
        <tr>
            <th>ISBN</th>
            <td><?= Html::encode($book->isbn) ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?= Html::encode($book->description) ?></td>
        </tr>
        <tr>
            <th>Authors</th>
            <td>
                <?php
                $authorNames = array_map(function($author) {
                    return Html::encode($author->full_name);
                }, $book->authors);
                echo implode(', ', $authorNames);
                ?>
            </td>
        </tr>
        <?php if ($book->cover_image): ?>
            <tr>
                <th>Cover</th>
                <td><?= Html::img($book->getCoverImageUrl(), ['alt' => $book->title, 'style' => 'max-width: 300px;']) ?></td>
            </tr>
        <?php endif; ?>
    </table>
</div>

