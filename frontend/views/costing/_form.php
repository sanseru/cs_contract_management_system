<?php

use frontend\models\ClientContract;
use frontend\models\Item;
use frontend\models\UnitRate;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
/** @var frontend\models\Costing $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsFile('@web/js/costing/script.js', ['depends' => [\yii\web\JqueryAsset::class], 'position' => \yii\web\View::POS_END]);

if (!$model->isNewRecord) {
    $activity_name = $model->item->masterActivityCode->activity_name;
    $type_name = $model->item->itemType->type_name;
    $size = $model->item->size;
    $class = $model->item->class;
    $combine = "'" . $activity_name . " " . $type_name . " " . $size . " " . $class . "'";

    $this->registerJs(
        <<<JS
            $(document).ready(function() {
                $('#contract_id').trigger('change');
                $('#item_id').val($model->item_id).change();
                var option = new Option($combine, $model->item_id, true, true);
                $('#item_id').append(option).trigger('change');
                $('#item_id').trigger('change');
            });
        JS
    );
}

$this->registerJs(
    <<<JS
        $('#contract_id').select2();
        $('#item_id').select2({
            ajax: {
                url: '/item/select2-get',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data, params) {

                    return {
                    results: $.map(data.results, function (obj) {
                        return {id: obj.id, text: obj.activity_name, type_name: obj.type_name, size: obj.size,class: obj.class, 'data-customer': obj.id};
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
                if(data.type_name){
                    return data.text + ' - ' + data.type_name + ' - ' + data.size + ' - ' + data.class;

                }else{

                return data.text;

                }
            }
        });

        function templateResult(option) {
            var \$option = $(
                '<div><strong style=\"font-size:14px;\"> Activity : ' + 
                    option.text 
                + '</strong></div><div class=\"row\"><i style=\"font-size:11px\"><div class=\"col\"><b> Type: '+ option.type_name +'</b></div><div class=\"col\"><b> Size: '+option.size+'</b></div><div class=\"col\"><b> Class: '+option.class+'</b></div></i></div>'
            );
            return \$option;
        }

        $("#costing-price").keyup(function(){   // 1st way
            var currency = $('#costing-price').val();
            var myFieldValue = $('#costing-price').inputmask('unmaskedvalue');
            // console.log(myFieldValue);
            const resultField = document.getElementById('teks_number');
            const text = currencyToWords(myFieldValue);
            resultField.style.fontWeight = "bold";
            resultField.style.fontSize = "15px";
            resultField.style.color = "red";
            resultField.innerHTML = text.toUpperCase();
            const priceTextDiv = document.getElementById('price_text_div');
            priceTextDiv.style.display = 'block';

        });
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
<div class="costing-form">
    <div class="card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'contract_id')->dropDownList(
                    ArrayHelper::map(ClientContract::find()->all(), 'id', 'contract_number'),
                    ['id' => 'contract_id', 'class' => 'form-control', 'prompt' => 'Select a Contract ...']
                )->label('Contract Number') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'clientName')->textInput(['readonly' => true, 'id' => 'client_name']) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= $form->field($model, 'item_id')->dropDownList([], ['id' => 'item_id', 'class' => 'form-control form-select', 'prompt' => 'Select a Item ...', 'style' => 'width:100%',])->label('Item') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'unit_rate_id')->dropDownList([], ['id' => 'rate_id', 'prompt' => 'Select unit Rate...']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'price')
                    ->textInput(['maxlength' => true, 'enableClientValidation' => false])
                    ->widget(\yii\widgets\MaskedInput::class, [
                        'clientOptions' => [
                            'alias' => 'numeric',
                            'groupSeparator' => ',',
                            'autoGroup' => true,
                            'digits' => 0,
                            'prefix' => 'IDR ',
                            'removeMaskOnSubmit' => true,
                        ],
                        'options' => [
                            'autocomplete' => 'off',
                        ],
                    ]);
                ?>
            </div>
            <div class="col-md-8" id="price_text_div" style="display:none">
                <label for="" class="form-label">&nbsp;</label>
                <div id="teks_number" class="uppercase form-control" style="border: none;"></div>
            </div>
        </div>
        <?= $form->field($model, 'client_id')->hiddenInput(['id' => 'client_id'])->label(false) ?>
    </div>

    <div class="form-group text-center card-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-createcust']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</div>