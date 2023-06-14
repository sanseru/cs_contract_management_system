<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransItem $model */

$this->title = 'Update Request Order Trans Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Request Order Trans Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="request-order-trans-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
