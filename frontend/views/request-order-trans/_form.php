<?php

use frontend\models\ClientContract;
use frontend\models\Costing;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTrans $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCss("
.select2-container .select2-selection--single {
    height: 36px;
}
.form-control:disabled, .form-control[readonly] {
    background-color: #e9ecef;
    opacity: 1;
}
");
?>

<div class="request-order-trans-form">

    <?php $form = ActiveForm::begin(['id' => 'addCosting']); ?>
    <?= $form->field($model, 'contract_number')->textInput(['disabled'=>true]) ?>
    <?= $form->field($model, 'costing_name')->dropDownList(['1'=>1],['id'=>'costing_name', 'class'=>"costings",'prompt' => 'Select unit Rate...']) ?>

    <?= 
    $form->field($model, 'costing_id')->dropDownList(
                    ArrayHelper::map(Costing::find()->where(['client_id' => $client_id])->all(), 'id', 'unitRate.rate_name'),
                    ['id' => 'costing_id', 'class' => 'form-control', 'prompt' => 'Select a Costing ...']
                )->label('Costing') 
                
                ?>
    <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>


    <?= $form->field($model, 'sub_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'request_order_id')->hiddenInput()->label(false) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
