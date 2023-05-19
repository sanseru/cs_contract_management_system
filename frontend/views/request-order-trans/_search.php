<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-order-trans-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'request_order_id') ?>

    <?= $form->field($model, 'costing_id') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'sub_total') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
