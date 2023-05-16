<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\MasterActivity $model */

$this->title = 'Update Master Activity: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Master Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-activity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
