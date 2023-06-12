<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValueUnitRate $model */

$this->title = 'Create Contract Activity Value Unit Rate';
$this->params['breadcrumbs'][] = ['label' => 'Contract Activity Value Unit Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-activity-value-unit-rate-create">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>