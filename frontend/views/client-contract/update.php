<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ClientContract $model */

$this->title = 'Update Client Contract: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Client Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-contract-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
