<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ClientContract $model */

$reqOrder = isset($_GET['req_order']) ? $_GET['req_order'] : null;

$this->title = 'Update Client Contract: ' . $model->contract_number;

if ($reqOrder) {
    $this->params['breadcrumbs'][] = ['label' => 'Client', 'url' => ['/client/view', 'id' => $reqOrder]];
    // $this->params['breadcrumbs'][] = ['label' => 'Client Contracts', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
} else {
    $this->params['breadcrumbs'][] = ['label' => 'Client Contracts', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'Update';
}


?>
<div class="client-contract-update">
    <div class="card">

        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>