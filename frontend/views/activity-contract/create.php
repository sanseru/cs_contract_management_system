<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ActivityContract $model */

$this->title = 'Create Activity Contract';
$this->params['breadcrumbs'][] = ['label' => 'Activity Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activity-contract-create">
    <div class="card">
        <div class="card-body">
            <h5><?= Html::encode($this->title) ?></h5>
            <hr>
            <?= $this->render('_form', [
                'model' => $model,
                'id' => $id,
            ]) ?>

        </div>
    </div>
</div>