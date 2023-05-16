<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ClientContract $model */

$this->title = 'Create Client Contract';
$this->params['breadcrumbs'][] = ['label' => 'Client Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-contract-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
