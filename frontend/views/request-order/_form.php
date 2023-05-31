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
// var_dump($model->isNewRecord);die;
$this->registerJs("
// $('#so_number').select2({
//     minimumInputLength: 2,
//     ajax: {
//         url: 'https://erp2.ptcs.co.id/api/sales/sales-order/select2?_type=query',
//         dataType: 'json',
//         delay: 250,
//         data: function(params) {
//             return {
//                 q: params.term
//             };
//         },
//         processResults: function(data, params) {
//             return {
//               results: $.map(data.data, function (obj) {
//                 return {id: obj.SO_Number, text: obj.SO_Number, customer: obj.customer, date: obj.date, 'data-customer': obj.customer};
//               }),

//             };
//         },      
//         cache: true
//     },
//     templateResult: templateResult,
//     placeholder: 'Select a client ...',
//     allowClear: true,
//     templateSelection: function (data, container) {
//         // Add custom attributes to the <option> tag for the selected option
//         $(data.element).attr('data-customer', data.customer);
//         return data.text;
//     }
// }).on('change', function() {
//     // Ambil nilai customer dari opsi yang dipilih
//     var selectedOption = $(this).find('option:selected');
//     var customer = selectedOption.attr('data-customer');
//     // Masukkan nilai customer ke field lain
//     // $('#client_name').val(customer);
// });

// function templateResult(option) {
//     var \$option = $(
//         '<div><strong style=\"font-size:14px;\">' + 
//             option.text 
//         + '</strong></div><div class=\"row\"><i style=\"font-size:11px\"><div class=\"col\">'+ option.customer +'</div><div class=\"col\">'+option.date+'</div></i></div>'
//     );
//     return \$option;
// }

// $('#start_date').datepicker({
//     dateFormat: 'yy-mm-dd'
// });
// $('#end_date').datepicker({
//     dateFormat: 'yy-mm-dd'
// });
");


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