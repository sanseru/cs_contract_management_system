<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ActivityContract $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJs(
    <<<JS
    $(document).ready(function() {
    $('#desc').summernote({
        height: 280

    });
    });
JS
);

?>

<div class="activity-contract-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'activity')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'activityBy')->textInput(['value' => Yii::$app->user->identity->username, 'maxlength' => true, 'label' => 'Activity By']) ?>
        </div>
    </div>
    <?= $form->field($model, 'description')->textarea(['rows' => 80, 'id' => 'desc']) ?>
    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>