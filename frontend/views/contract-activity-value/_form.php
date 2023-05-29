<?php

use frontend\models\MasterActivity;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValue $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contract-activity-value-form">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $contract_id])->label(false) ?>

                <?= $form->field($model, 'activity_id')->dropDownList(
                    ArrayHelper::map(MasterActivity::find()->all(), 'id', 'activity_name'),
                    [
                        'prompt' => 'Select an option...', 'id' => 'activity_id'
                    ]
                )->label('Activity Name') ?>

                <?= $form->field($model, 'value')->textInput(['maxlength' => true])->widget(\yii\widgets\MaskedInput::class, [
                    'clientOptions' => [
                        'alias' => 'numeric',
                        'groupSeparator' => ',',
                        'autoGroup' => true,
                        'digits' => 0,
                        'prefix' => 'IDR ',
                        'removeMaskOnSubmit' => true,
                    ],
                    'options' => [
                        'autocomplete' => 'off',
                    ],
                ]); ?>

                <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $contract_id])->label(false) ?>

                <div class="d-grid gap-2 form-group mt-3 text-center">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>