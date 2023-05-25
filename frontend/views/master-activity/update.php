<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\MasterActivity $model */

$this->title = 'Update : ' . $model->activity_name;
$this->params['breadcrumbs'][] = ['label' => 'Master Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->activity_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-activity-update">
    <div class="card">
        <h6 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h6>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>