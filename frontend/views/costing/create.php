<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Costing $model */

$this->title = 'Create Costing';
$this->params['breadcrumbs'][] = ['label' => 'Costings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costing-create">
    <div class="card">
    <div class="card-header"><?= Html::encode($this->title) ?></div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
