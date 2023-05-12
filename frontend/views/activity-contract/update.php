<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ActivityContract $model */

$this->title = 'Update Activity Contract: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Activity Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="activity-contract-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
