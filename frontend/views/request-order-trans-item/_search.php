<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransItemSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-order-trans-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'request_order_id') ?>

    <?= $form->field($model, 'request_order_trans_id') ?>

    <?= $form->field($model, 'resv_number') ?>

    <?= $form->field($model, 'ce_year') ?>

    <?php // echo $form->field($model, 'cost_estimate') ?>

    <?php // echo $form->field($model, 'ro_number') ?>

    <?php // echo $form->field($model, 'material_incoming_date') ?>

    <?php // echo $form->field($model, 'ro_start') ?>

    <?php // echo $form->field($model, 'ro_end') ?>

    <?php // echo $form->field($model, 'urgency') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'id_valve') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'class') ?>

    <?php // echo $form->field($model, 'equipment_type') ?>

    <?php // echo $form->field($model, 'sow') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'date_to_status') ?>

    <?php // echo $form->field($model, 'progress') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
