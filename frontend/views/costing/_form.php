<?php

use frontend\models\ClientContract;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\Costing $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs(
    <<<JS
        $('#contract_id').select2();
        $('#client_id').select2("readonly", true);
    JS
);

?>

<div class="costing-form">
<style>
    .select2-container.select2-container-disabled .select2-choice {
  background-color: #ddd;
  border-color: #a8a8a8;
}
</style>
    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'contract_id')->dropDownList(
        ArrayHelper::map(ClientContract::find()->all(), 'id', 'contract_number'),
        ['id' => 'contract_id', 'class' => 'form-control', 'prompt' => 'Select a Contract ...']
    )->label('Contract Number') ?>

    <?= $form->field($model, 'client_id')->dropDownList(
        [],
        ['prompt' => 'Select', 'id' => 'client_id','readonly'=>true]
    ) ?>

    <?= $form->field($model, 'unit_rate_id')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>