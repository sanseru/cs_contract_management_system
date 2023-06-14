<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValueUnitRate $model */

$this->title = 'Add Activity Unit Rate';
$this->params['breadcrumbs'][] = ['label' => 'Contract Activity Unit Rates', 'url' => ['contract-activity-value/view','id' => Yii::$app->request->get('act_val_id'), 'contract_id'=>Yii::$app->request->get('contract_id'),'req_order'=>Yii::$app->request->get('req_order')]];
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