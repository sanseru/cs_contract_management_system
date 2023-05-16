<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Costing $model */

$this->title = 'Update Costing: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Costings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="costing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
