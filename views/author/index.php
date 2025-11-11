<?php

declare(strict_types=1);

use yii\bootstrap5\LinkPager;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Authors';
?>
<div class="author-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Create Author', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <p>
        Показано <?= $dataProvider->getCount() ?> из <?= $dataProvider->getTotalCount() ?> авторов
    </p>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataProvider->getModels() as $author): ?>
                    <tr>
                        <td><?= $author->id ?></td>
                        <td><?= Html::encode($author->full_name) ?></td>
                        <td>
                            <?= Html::a('View', ['view', 'id' => $author->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            <?php if (!Yii::$app->user->isGuest): ?>
                                <?= Html::a('Update', ['update', 'id' => $author->id], ['class' => 'btn btn-sm btn-warning']) ?>
                                <?= Html::a('Delete', ['delete', 'id' => $author->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this author?',
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

