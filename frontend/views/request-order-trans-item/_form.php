<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransItem $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-order-trans-item-form">
    <div class="card-body">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'request_order_id')->hiddenInput(['value' => Yii::$app->request->get('req_order')])->label(false) ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'resv_number')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'ce_year')->textInput(['maxlength' => true]) ?>

            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'cost_estimate')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'ro_number')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">

            <div class="col-md-3">
                <?= $form->field($model, 'material_incoming_date')->widget(\yii\jui\DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => ['class' => 'form-control'],
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'ro_start')->widget(\yii\jui\DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => ['class' => 'form-control'],
                ]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'ro_end')->widget(\yii\jui\DatePicker::class, [
                    'dateFormat' => 'dd-MM-yyyy',
                    'options' => ['class' => 'form-control'],
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'urgency')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'qty')->textInput() ?>

            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'id_valve')->textInput(['maxlength' => true]) ?>

            </div>

        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'equipment_type')->textInput(['maxlength' => true]) ?>
            </div>

        </div>

        <?= $form->field($model, 'sow')->textarea(['rows' => 6]) ?>


        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>