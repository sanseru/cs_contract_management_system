<?php

use frontend\models\UnitRate;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\BaseArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValueUnitRate $model */
/** @var yii\widgets\ActiveForm $form */


$this->registerJs(
    <<<JS
        $('#contractactivityvalueunitrate-unit_rate_id').select2();
    JS
);

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

<div class="contract-activity-value-unit-rate-form">

    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'contract_id')->hiddenInput(['value' => Yii::$app->request->get('contract_id')])->label(false) ?>

                <?= $form->field($model, 'activity_value_id')->hiddenInput(['value' => Yii::$app->request->get('act_val_id')])->label(false) ?>

                <?= $form->field($model, 'unit_rate_id')->dropDownList(
                    BaseArrayHelper::map(UnitRate::find()->all(), 'id', 'rate_name'),
                    [
                        'prompt' => 'Select an option...'
                    ]
                )->label('Activity Name') ?>

                <div class="d-grid gap-2 form-group mt-3 text-center">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>