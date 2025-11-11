<?php

declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Author $author */

$this->title = $author->full_name;
?>
<div class="author-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (!Yii::$app->user->isGuest): ?>
            <?= Html::a('Update', ['update', 'id' => $author->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $author->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this author?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <table class="table">
        <tr>
            <th>Full Name</th>
            <td><?= Html::encode($author->full_name) ?></td>
        </tr>
        <tr>
            <th>Books</th>
            <td>
                <ul>
                    <?php foreach ($author->books as $book): ?>
                        <li><?= Html::a(Html::encode($book->title), ['/book/view', 'id' => $book->id]) ?> (<?= $book->year ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
    </table>

    <h2>Subscribe to new books</h2>
    <?php $form = ActiveForm::begin(['action' => ['/subscription/subscribe', 'authorId' => $author->id]]); ?>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="+79001234567" required>
        </div>
        <?= Html::submitButton('Subscribe', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end(); ?>
</div>

