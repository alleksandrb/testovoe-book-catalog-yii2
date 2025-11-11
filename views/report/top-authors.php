<?php

declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $topAuthors */
/** @var int $year */

$this->title = 'Top Authors Report';
?>
<div class="report-top-authors">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['method' => 'get']); ?>
        <div class="form-group">
            <label>Year</label>
            <input type="number" name="year" value="<?= $year ?>" class="form-control" min="1000" max="9999">
        </div>
        <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>

    <h2>Top 10 Authors for <?= $year ?></h2>

    <?php if (empty($topAuthors)): ?>
        <p>No data found for this year.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Author</th>
                    <th>Books Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topAuthors as $index => $item): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= Html::encode($item['author_name']) ?></td>
                        <td><?= $item['books_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

