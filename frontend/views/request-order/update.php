<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Contract $model */

$this->title = 'Update Contract: ' . $model->contract->contract_number;
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->contract->contract_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contract-update">
    <div class="card">
        <h5 class="card-header"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
            // 'client' => $client,

        ]) ?>
    </div>
</div>