<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Client $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="client-form">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>

            </div>
        </div>
    </div>
    <div class="form-group mt-2 card-footer text-center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-createcust']) ?>
        <?= Html::a('Cancel', ['/client/index'], ['class' => 'btn btn-cancelform']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>