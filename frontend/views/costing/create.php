<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Costing $model */

$this->title = 'Create Costing';
$this->params['breadcrumbs'][] = ['label' => 'Costings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
