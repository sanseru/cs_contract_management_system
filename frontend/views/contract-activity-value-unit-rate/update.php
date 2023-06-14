<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValueUnitRate $model */

$this->title = 'Update Contract Activity Value Unit Rate: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Contract Activity Value Unit Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contract-activity-value-unit-rate-update">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>