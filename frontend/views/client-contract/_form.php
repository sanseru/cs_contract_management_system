<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ClientContract $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="client-contract-form">
    <div class="card-body">

        <?php $form = ActiveForm::begin(); ?>


        <?= $form->field($model, 'contract_number')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'start_date')->textInput() ?>

        <?= $form->field($model, 'end_date')->textInput() ?>



        <div class="form-group mt-3">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>