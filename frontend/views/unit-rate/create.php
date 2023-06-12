<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\UnitRate $model */

$this->title = 'Create Unit Rate';
$this->params['breadcrumbs'][] = ['label' => 'Unit Rates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-rate-create">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>