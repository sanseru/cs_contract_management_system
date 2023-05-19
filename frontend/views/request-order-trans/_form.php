<?php

use frontend\models\ClientContract;
use frontend\models\Costing;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTrans $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-order-trans-form">

    <?php $form = ActiveForm::begin(['id' => 'addCosting']); ?>

    <?= $form->field($model, 'request_order_id')->hiddenInput()->label(false) ?>


    <?= $form->field($model, 'costing_id')->dropDownList(
                    ArrayHelper::map(Costing::find()->where(['client_id' => $client_id,'client_id' => $client_id])->all(), 'id', 'contract_number'),
                    ['id' => 'contract_id', 'class' => 'form-control', 'prompt' => 'Select a Contract ...']
                )->label('Contract Number') ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_total')->textInput(['maxlength' => true]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
