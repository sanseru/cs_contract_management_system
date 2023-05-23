<?php

use frontend\models\ClientContract;
use frontend\models\Item;
use frontend\models\UnitRate;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var frontend\models\Costing $model */
/** @var yii\widgets\ActiveForm $form */
$this->registerJs(
    <<<JS
        $('#contract_id').select2();
        $('#item_id').select2();



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

        <?php
        $getUrl = Url::to(['client/find-model']);

        $script = <<< JS
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
        JS;
        $this->registerJs($script);
        ?>
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
                <?= $form->field($model, 'item_id')->dropDownList(
                    ArrayHelper::map(Item::find()->all(), 'id', 
                    function($item) {
                        return $item->masterActivityCode->activity_name. ' - ' .$item->itemType->type_name . ' (' . $item->size . ')';
                    }
                ),
                    ['id' => 'item_id', 'class' => 'form-control form-select', 'prompt' => 'Select a Contract ...']
                )->label('Item') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'unit_rate_id')->dropDownList(ArrayHelper::map(UnitRate::find()->all(), 'id', 'rate_name'), ['id' => 'rate_id', 'prompt' => 'Select unit Rate...']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'price')
                    ->textInput(['maxlength' => true, 'enableClientValidation' => false])
                    ->widget(\yii\widgets\MaskedInput::className(), [
                        'clientOptions' => [
                            'alias' => 'numeric',
                            'groupSeparator' => ',',
                            'autoGroup' => true,
                            'digits' => 0,
                            'prefix' => 'IDR ',
                            'removeMaskOnSubmit' => true,
                        ],
                        'options' => [
                            // 'class' => 'form-control',
                            'autocomplete' => 'off',
                            // 'onchange'=>'
                            // alert("cobas");'
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
        <div class="form-group d-md-flex justify-content-md-end">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs(
    <<<JS
            function rupiahToWords(number) {
            let words = {
                ones: ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'],
                tens: ['', 'sepuluh', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'],
                hundreds: ['', 'seratus', 'dua ratus', 'tiga ratus', 'empat ratus', 'lima ratus', 'enam ratus', 'tujuh ratus', 'delapan ratus', 'sembilan ratus'],
                rupiah: ['', 'ribu', 'juta', 'miliar', 'triliun']
            };

            if (typeof number === 'number') {
                number = String(number);
            }

            let rupiahArr = number.split('').reverse();
            let result = [];

            for (let i = 0, rupiahIndex = 0; i < rupiahArr.length; i += 3, rupiahIndex++) {
                let rupiahGroup = rupiahArr.slice(i, i + 3).reverse().join('');
                let wordsArr = [];

                if (rupiahGroup === '000') {
                continue;
                }

                if (rupiahGroup.length === 3 && rupiahGroup[0] !== '0') {
                let hundreds = Number(rupiahGroup[0]);
                wordsArr.push(words.hundreds[hundreds]);
                }

                if (rupiahGroup.length >= 2) {
                let tens = Number(rupiahGroup[rupiahGroup.length - 2]);
                let ones = Number(rupiahGroup[rupiahGroup.length - 1]);

                if (tens === 1) {
                    let teen = Number(rupiahGroup.slice(-2));
                    wordsArr.push(words.ones[teen]);
                } else {
                    if (tens !== 0) {
                    wordsArr.push(words.tens[tens]);
                    }

                    if (ones !== 0) {
                    wordsArr.push(words.ones[ones]);
                    }
                }
                } else {
                let ones = Number(rupiahGroup[rupiahGroup.length - 1]);
                if (ones !== 0) {
                    wordsArr.push(words.ones[ones]);
                }
                }

                if (rupiahIndex > 0 && wordsArr.length > 0) {
                wordsArr.push(words.rupiah[rupiahIndex]);
                }

                result.unshift(wordsArr.join(' '));
            }

            return result.join(' ');
            }



            function currencyToWords(currency) {

            // var currencyArray = currency.split(' ');

            // var amount = parseInt(currencyArray[1].replace(',', ''));
            var currencyArray = currency;
            var amount = parseInt(currencyArray);

            var currencyWord = '';

            switch (currencyArray) {

                case 'IDR':
                    currencyWord = 'rupiah';
                    break;
                default:
                    currencyWord = '';

            }

            var amountWord = rupiahToWords(amount);

            var result = 'Total : '+ amountWord + ' ' + currencyWord + ' Rupiah';

            return result;
            }

    JS
);

?>