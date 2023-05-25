<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ActivityContract $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJsFile('@web/js/activity_contract/script.js', ['depends' => [\yii\web\JqueryAsset::class], 'position' => \yii\web\View::POS_END]);

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
    <?= $form->field($model, 'status')->dropDownList([1 => 'Open', 2 => 'On Proggress', 9 => 'Close'], [
        'prompt' => '- Select Status -',         'value' => $model->isNewRecord ? 1 : $model->status
    ]) ?>

    <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $id])->label(false) ?>

    <div class="form-group d-md-flex justify-content-md-end">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>