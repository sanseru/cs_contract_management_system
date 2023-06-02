<?php

use frontend\models\UnitRate;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\MasterActivity $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJs(
    <<<JS
        $('#unit_rate_id').select2();
    JS
);

if (!$model->isNewRecord) {
    $this->registerJs(<<<JS
        $(document).ready(function() {
            $('#unit_rate_id').val($model->unitrate_activity).change();

        });
JS);
}

?>

<div class="master-activity-form">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'activity_code')->textInput(['maxlength' => true, 'enableAjaxValidation' => true]) ?>

                <?= $form->field($model, 'activity_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'unitrate_activity')->dropDownList(
                    ArrayHelper::map(UnitRate::find()->all(), 'id', 'rate_name'),
                    [
                        'multiple' => 'multiple',
                        'prompt' => 'Select an option...', 'id' => 'unit_rate_id'
                    ]
                ) ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'has_item')->checkbox() ?>

                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'has_sow')->checkbox() ?>

                    </div>
                </div>
                <div class="d-grid gap-2 form-group mt-3 text-center">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>

</div>