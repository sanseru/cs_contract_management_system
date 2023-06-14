<?php

use frontend\models\ClientContract;
use frontend\models\MasterActivity;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrder $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs(
    <<<JS
    $('#activity').select2();
    $('#contract_id').change(function(){
            var contractId = $(this).val();
            $.ajax({
                url: '/client/get-client',
                data: { id: contractId },
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // handle success response here
                    console.log(response);
                    $('#client_name').val(response.name)
                    $('#client_id').val(response.id)
                },
                error: function(error) {
                    // handle error response here
                    alert(error.responseText);

                }
            });
        });
JS
);

if (!$model->isNewRecord) {
    $this->registerJs(<<<JS
        $(document).ready(function() {
            $('#activity').val($model->activityCodeArray).change();
            $('#contract_id').trigger('change');

        });
JS);
}


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


<div class="card-body">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'contract_id')->dropDownList(
                ArrayHelper::map(ClientContract::find()->all(), 'id', 'contract_number'),
                ['id' => 'contract_id', 'class' => 'form-control', 'prompt' => 'Select a Contract ...']
            )->label('Contract Number') ?>
        </div>
        <div class="col-md-4">
            <?= Html::label('Client Name', 'client_name', ['class' => 'form-label']) ?>
            <?= Html::input('text', 'client_name', null, ['class' => 'form-control', 'id' => 'client_name', 'readonly' => true]) ?>
            <?= $form->field($model, 'client_id', ['enableClientValidation' => false])->hiddenInput(['id' => 'client_id'])->label(false) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'so_number')->textInput(['maxlength' => true, 'autocomplete'=> 'off']) ?>



            <?php // Html::dropDownList('client_name', '', [], ['id' => 'client_name', 'class' => 'form-control', 'prompt' => 'Select a Client Name ...',])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'ro_number')->textInput(['maxlength' => true, 'autocomplete'=> 'off']) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'contract_type')->dropDownList(
                [
                    'RO' => 'RO',
                    'WO' => 'WO',
                ],
                ['prompt' => 'Select an option...']
            ) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'activityCodeArray')->dropDownList(
                ArrayHelper::map(MasterActivity::find()->all(), 'id', 'activity_name'),
                [
                    'multiple' => 'multiple',
                    'prompt' => 'Select an option...', 'id' => 'activity'
                ]
            ) ?>


        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'start_date')->widget(DatePicker::class, [
                'dateFormat' => 'dd-MM-yyyy', // format tanggal yang digunakan
                'options' => ['class' => 'form-control', 'autocomplete'=> 'off'], // opsi tambahan untuk input field
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'end_date')->widget(DatePicker::class, [
                'dateFormat' => 'dd-MM-yyyy', // format tanggal yang digunakan
                'options' => ['class' => 'form-control', 'autocomplete'=> 'off'], // opsi tambahan untuk input field
            ]) ?>

        </div>
    </div>
    <?= $form->field($model, 'status')->dropDownList([1 => 'Open', 9 => 'Close'], ['prompt' => '- Select Status -', 'value' => 1]) ?>
</div>
<div class="form-group mt-1 text-center card-footer">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary text-white fw-bold btn-createcust']) ?>
</div>
<?php ActiveForm::end(); ?>