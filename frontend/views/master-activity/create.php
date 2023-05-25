<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\MasterActivity $model */

$this->title = 'Create Master Activity';
$this->params['breadcrumbs'][] = ['label' => 'Master Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-activity-create">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>