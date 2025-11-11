<?php

declare(strict_types=1);

use app\models\Author;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $book */

$this->title = 'Create Book';
?>
<div class="book-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($book, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($book, 'year')->textInput(['type' => 'number']) ?>
        <?= $form->field($book, 'isbn')->textInput(['maxlength' => true]) ?>
        <?= $form->field($book, 'description')->textarea(['rows' => 6]) ?>
        <?= $form->field($book, 'coverFile')->fileInput() ?>

        <div class="form-group">
            <label>Authors</label>
            <?php foreach (Author::find()->all() as $author): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="authorIds[]" value="<?= $author->id ?>" id="author_<?= $author->id ?>">
                    <label class="form-check-label" for="author_<?= $author->id ?>">
                        <?= Html::encode($author->full_name) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>

