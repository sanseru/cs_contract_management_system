<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\UnitRate $model */

$this->title = 'Update Unit Rate: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Unit Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="unit-rate-update">
    <div class="card">
        <h6 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h6>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>