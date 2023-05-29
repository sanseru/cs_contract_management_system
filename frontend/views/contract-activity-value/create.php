<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValue $model */

$this->title = 'Create Contract Activity Value';
$this->params['breadcrumbs'][] = ['label' => 'Client Contrac', 'url' => ['/client-contract/view', 'id'=> $contract_id, 'req_order'=> $req_order]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-activity-value-create">

    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
            'contract_id' => $contract_id,
            'req_order' => $req_order,
        ]) ?>

    </div>
</div>