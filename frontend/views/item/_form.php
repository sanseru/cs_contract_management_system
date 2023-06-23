<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
use frontend\models\MasterActivity;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\Item $model */
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


$this->registerJs(
    <<<JS
        $('#acivity').select2();
        $('#item_type').select2();
    JS
);

if (!$model->isNewRecord) {
    $getUrl = Url::to(['item-type/get-item-types']);

    $script = <<< JS
        var activityCode = '$model->master_activity_code';
        $.get('{$getUrl}?activityCode=' + activityCode, function(data){
            $('#item_type').html(data).val($model->item_type_id).trigger('change');
        });
    JS;
$this->registerJs($script);
}
?>

<div class="item-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php
    $getUrl = Url::to(['item-type/get-item-types']);

    $script = <<< JS
        $('#activity').change(function(){
            var activityCode = $(this).val();
            $.get('{$getUrl}?activityCode=' + activityCode, function(data){
                $('#item_type').html(data);
            });
        });
    JS;
    $this->registerJs($script);
    ?>



    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'master_activity_code')->dropDownList(
                ArrayHelper::map(MasterActivity::find()->all(), 'id', 'activity_name'),
                ['id' => 'activity', 'class' => 'form-control', 'prompt' => 'Select a Activity Name ...']
            )->label('Activity') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'item_type_id')->dropDownList(
                [],
                ['prompt' => 'Select', 'id' => 'item_type', 'required'=> true]
            ) ?>
        </div>
    </div>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'class')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>