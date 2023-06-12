<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\UnitRate $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="unit-rate-form">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'rate_name')->textInput(['maxlength' => true]) ?>

                <div class="form-group mt-3">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>