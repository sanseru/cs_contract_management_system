<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var frontend\models\Contract $model */
/** @var yii\widgets\ActiveForm $form */
// var_dump($model->isNewRecord);die;
$this->registerJs("
$('#so_number').select2({
    minimumInputLength: 2,
    ajax: {
        url: 'https://erp2.ptcs.co.id/api/sales/sales-order/select2?_type=query',
        dataType: 'json',
        delay: 250,
        data: function(params) {
            return {
                q: params.term
            };
        },
        processResults: function(data, params) {
            return {
              results: $.map(data.data, function (obj) {
                return {id: obj.SO_Number, text: obj.SO_Number, customer: obj.customer, date: obj.date, 'data-customer': obj.customer};
              }),

            };
        },      
        cache: true
    },
    templateResult: templateResult,
    placeholder: 'Select a client ...',
    allowClear: true,
    templateSelection: function (data, container) {
        // Add custom attributes to the <option> tag for the selected option
        $(data.element).attr('data-customer', data.customer);
        return data.text;
    }
}).on('change', function() {
    // Ambil nilai customer dari opsi yang dipilih
    var selectedOption = $(this).find('option:selected');
    var customer = selectedOption.attr('data-customer');
    // Masukkan nilai customer ke field lain
    // $('#client_name').val(customer);
});

function templateResult(option) {
    var \$option = $(
        '<div><strong style=\"font-size:14px;\">' + 
            option.text 
        + '</strong></div><div class=\"row\"><i style=\"font-size:11px\"><div class=\"col\">'+ option.customer +'</div><div class=\"col\">'+option.date+'</div></i></div>'
    );
    return \$option;
}

$('#start_date').datepicker({
    dateFormat: 'yy-mm-dd'
});
$('#end_date').datepicker({
    dateFormat: 'yy-mm-dd'
});
");


$this->registerJs(
    <<<JS
$('#client_name').select2({
    ajax: {
        url: '/client/select2-get',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term, // Search term
            };
        },
        processResults: function (data) {
            return {
                results: data.results,
            };
        },
        cache: true,
    },
    placeholder: 'Select a client',
    minimumInputLength: 0,
    tags: true,
});

$('#activity').select2();


JS
);

if (!$model->isNewRecord) {
    $this->registerJs("
        $(document).ready(function() {
            var option = new Option('" . $model->so_number . "', '" . $model->so_number . "', true, true);
            $('#so_number').append(option).trigger('change');
            $('#so_number').trigger('change');
            // $('#client_name').val('" . (!empty($client) && !empty($client->name) ? $client->name : "") . "'); 
            
            var optionCLient = new Option('" . $client->name. "', '" . $model->client_id   . "', true, true);
            $('#client_name').append(optionCLient).trigger('change');
            $('#client_name').trigger('change');
        });
    ");
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
            <?= $form->field($model, 'contract_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <!-- <?php // Html::label('SO Number', 'so_number', ['class' => 'form-label']) 
                    ?> -->
            <!-- <?php // Html::dropDownList('so_number', '', [], ['id' => 'so_number','class' => 'form-control','prompt' => 'Select a So Number ...',]) 
                    ?> -->
            <?= $form->field($model, 'so_number')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= Html::label('Client Name', 'client_name', ['class' => 'form-label']) ?>

            <?php // Html::input('text', 'client_name', null, ['class' => 'form-control', 'id' => 'client_name', 'readonly' => false]) 
            ?>

            <?= Html::dropDownList('client_name', '', [], ['id' => 'client_name', 'class' => 'form-control', 'prompt' => 'Select a Client Name ...',])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'contract_type')->dropDownList(
                [
                    'RO' => 'RO',
                    'WO' => 'WO',
                ],
                ['prompt' => 'Select an option...']
            ) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'activity')->dropDownList(
                [
                    'PM' => 'PM',
                    'SWD' => 'SWD',
                    'REPR' => 'REPAIR',

                ],
                [
                    'multiple' => 'multiple',
                    'prompt' => 'Select an option...', 'id' => 'activity'
                ]
            ) ?>

        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'start_date')->widget(DatePicker::className(), [
                'dateFormat' => 'dd-MM-yyyy', // format tanggal yang digunakan
                'options' => ['class' => 'form-control'], // opsi tambahan untuk input field
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'end_date')->widget(DatePicker::className(), [
                'dateFormat' => 'dd-MM-yyyy', // format tanggal yang digunakan
                'options' => ['class' => 'form-control'], // opsi tambahan untuk input field
            ]) ?>

        </div>
    </div>

    <?= $form->field($model, 'status')->dropDownList([1 => 'Open', 9 => 'Close'], ['prompt' => '- Select Status -', 'value' => 1]) ?>
    <div class="form-group mt-5 d-md-flex justify-content-md-end ">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary text-white']) ?>
    </div>
    <?php ActiveForm::end(); ?>