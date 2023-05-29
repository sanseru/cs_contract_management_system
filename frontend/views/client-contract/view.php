<?php

use frontend\models\ClientContract;
use frontend\models\ContractActivityValue;
use frontend\models\Costing;
use frontend\models\Item;
use frontend\models\UnitRate;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\ClientContract $model */
$reqOrder = isset($_GET['req_order']) ? $_GET['req_order'] : null;

$this->title = $model->contract_number;
if ($reqOrder) {
    $this->params['breadcrumbs'][] = ['label' => 'Client', 'url' => ['/client/view', 'id' => $reqOrder]];
    // $this->params['breadcrumbs'][] = ['label' => 'Client Contracts', 'url' => ['index']];
    $this->params['breadcrumbs'][] = 'Client Contract ' . $this->title;
} else {
    $this->params['breadcrumbs'][] = ['label' => 'Client Contracts', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
}

\yii\web\YiiAsset::register($this);
?>
<div class="client-contract-view">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white">#Contract Number <?= Html::encode($this->title) ?></h5>
        <div class="card-body">
            <!-- 
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'client.name',
                    'contract_number',
                    [
                        'attribute' => 'start_date',
                        'format' => ['date', 'php:d-m-Y']
                    ],
                    [
                        'attribute' => 'end_date',
                        'format' => ['date', 'php:d-m-Y']
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>

<ul class="nav nav-tabs nav-justified mt-3" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active fw-bold" id="costing-tab" data-bs-toggle="tab" data-bs-target="#costing-tab-pane" type="button" role="tab" aria-controls="costing-tab-pane" aria-selected="true">Costing</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-bold" id="kpi-tab" data-bs-toggle="tab" data-bs-target="#kpi-tab-pane" type="button" role="tab" aria-controls="kpi-tab-pane" aria-selected="false">KPI</button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="costing-tab-pane" role="tabpanel" aria-labelledby="costing-tab" tabindex="0">
        <?php Pjax::begin(['id' => 'my_pjax']); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <div class="card mt-3">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="text-white">#Costing for Contract Number <?= Html::encode($this->title) ?></h5>
                <?= Html::button('Add Costing', [
                    'class' => 'btn btn-info btn-sm btn-modal',
                    'data-target' => '#consting_client_contract', 'data-toggle' => 'modal'
                ]) ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <?= GridView::widget([
                        'dataProvider' => $dataCostingProvider,
                        'filterModel' => $searchModelCosting,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Client Name',
                                'attribute' => 'clientName',
                                'value' => 'client.name'
                            ],
                            [
                                'label' => 'Contract Number',
                                'attribute' => 'contractNumber',
                                'value' => 'clientContract.contract_number',
                                'contentOptions' => ['class' => 'text-center'],
                                'headerOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Rate Name',
                                'attribute' => 'rateName',
                                'value' => 'unitRate.rate_name'
                            ],
                            [
                                'label' => 'Item Detail',
                                'attribute' => 'itemDetail',
                                'contentOptions' => ['class' => 'fw-lighter', 'style' => 'font-size:10px'],
                                'format' => 'raw', // Set the format to 'raw'
                                'value' => function ($model) {

                                    return
                                        'Activity : ' . $model->item->masterActivityCode->activity_name . '<br>'
                                        . 'Type name : ' . $model->item->itemType->type_name . '<br>'
                                        . 'Size : ' . $model->item->size . '<br>'
                                        . 'Class : ' . $model->item->class;
                                }
                            ],
                            [
                                'attribute' => 'price',
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asCurrency($model->price, 'IDR');
                                }
                            ],
                            //'created_at',
                            //'updated_at',
                            [
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, Costing $model, $key, $index, $column) {
                                    if ($action === 'view') {
                                        return Url::to(['costing/view', 'id' => $model->id]);
                                    } elseif ($action === 'update') {
                                        return Url::to(['costing/update', 'id' => $model->id, 'contract_id' => $model->contract_id, 'url_back' => true]);
                                    } elseif ($action === 'delete') {
                                        return Url::to(['costing/delete', 'id' => $model->id, 'contract_id' => $model->contract_id, 'url_back' => true]);
                                    }
                                }
                            ],
                        ],
                    ]); ?>
                </div>

                <?php Pjax::end(); ?>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="kpi-tab-pane" role="tabpanel" aria-labelledby="kpi-tab" tabindex="0">
        <div class="card mt-3">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="text-white">#KPI for Contract Number <?= Html::encode($this->title) ?></h5>
                <?= Html::a('Add KPI Activity', ['contract-activity-value/create', 'id' => $model->id, 'url_back' => true, 'tab' => 'kpi', 'req_order' => Yii::$app->request->get('req_order')], [
                    'class' => 'btn btn-warning btn-sm',
                ]) ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); 
                    ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvidercav,
                        'filterModel' => $searchModelcav,
                        'options' => ['class' => 'table table-striped table-bordered text-sm text-center font-monospace table-responsive'],
                        'showFooter' => true, // this line enables the footer row
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            // 'id',
                            // 'contract_id',
                            [
                                'attribute' => 'activity.activity_name',
                                'footer' => 'Total'
                            ],
                            [
                                'attribute' => 'value',
                                'value' => function ($model) {
                                    return Yii::$app->formatter->asCurrency($model->value, 'IDR');
                                },
                                'footer' => ContractActivityValue::getTotal($dataProvidercav->models, 'value'),
                                'contentOptions' => ['class' => 'text-end'],
                                'footerOptions' => ['class' => 'text-end'],

                            ],
                            [
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, ContractActivityValue $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
Modal::begin([
    'title' => '<h5>Add Costing</h5>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'consting_client_contract',
    'size' => 'modal-lg', // ukuran modal: large, medium, small, fullscreen
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE]
]);



?>
<div id='modalContent'>
    <div class="card-body">

        <?php $form = ActiveForm::begin(['id' => 'my-form']); ?>

        <?php
        $getUrl = Url::to(['client/find-model']);

        $script = <<< JS
    $('#contract_id').change(function(){
        // var contractId = $(this).val();
        var client_id = $model->client_id;

        $.ajax({
            url: '/client/get-client',
            data: { id: client_id },
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
                <?= $form->field($costing, 'contract_id')->dropDownList(
                    ArrayHelper::map(ClientContract::find()->all(), 'id', 'contract_number'),
                    [
                        'id' => 'contract_id', 'class' => 'form-control',
                        'options' => [$model->id => ['selected' => true]],
                        'prompt' => 'Select a Contract ...',
                        'style' => 'width:100%',
                    ]
                )->label('Contract Number') ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($costing, 'clientName')->textInput(['readonly' => true, 'id' => 'client_name', 'value' => $model->client->name]) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <?= $form->field($costing, 'item_id')->dropDownList([], ['id' => 'item_id', 'class' => 'form-control form-select', 'prompt' => 'Select a Item ...', 'style' => 'width:100%',])->label('Item') ?>
            </div>
            <div class="col-md-2 mt-4">
                <?= Html::a('Create Item', ['item/create', 'next_url' => 'close_tab'], ['target' => '_blank', 'class' => 'mt-2 form-control form-label  btn-sm btn btn-secondary', 'title' => 'Create a new item if Not Found']) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($costing, 'unit_rate_id')->dropDownList([], ['id' => 'rate_id', 'prompt' => 'Select unit Rate...', 'style' => 'width:100%']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($costing, 'price')
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

        <?= $form->field($costing, 'client_id')->hiddenInput(['id' => 'client_id', 'value' => $model->client_id])->label(false) ?>
        <div class="form-group d-md-flex justify-content-md-end">

            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
<?php
Modal::end();
?>


<?php
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
        $(document).on('click', '.btn-modal', function (e) {
            $('#consting_client_contract').modal('show');
            $('#contract_id').trigger('change');


        });

        $(document).on('submit', '#my-form', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '/costing/create-ajax',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    $('#my-form')[0].reset();
                    $("#item_id").val(null).trigger("change"); // reset to empty state
                    $('#consting_client_contract').modal('hide');
                    $.pjax.reload({container:'#my_pjax'});
                    Swal.fire({
                    icon: 'success',
                    title: 'Data has been saved',
                    showConfirmButton: true,
                    timer: 1500
                    })
                },
                error: function() {
                    alert('An error occurred while submitting the form.');
                }
            });
        });

        $('#item_id').select2({
            dropdownParent: $("#consting_client_contract"),
            // minimumInputLength: 2,
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
        }).on('change', function() {
            var itemId = $(this).val();
            // Make an AJAX request to fetch select options based on item_id
            $.ajax({
                url: '/costing/fetch-options-unit-rate', // Replace with the actual URL to fetch select options
                type: 'GET',
                data: {item_id: itemId},
                dataType: 'json',
                success: function(response) {
                    // Clear existing options
                    $('#rate_id').empty();

                    $('#rate_id').append($('<option></option>').attr('value', '').text('Select unit Rate...'));

                    // Add new options based on the response
                    $.each(response, function(key, value) {
                        $('#rate_id').append($('<option></option>').attr('value', key).text(value));
                    });

                    // Refresh Select2 to reflect the updated options
                    $('#rate_id').trigger('change');
                },
                error: function() {
                    console.log('Error occurred while fetching select options.');
                }
            });
        });

        function templateResult(option) {
            var \$option = $(
                '<div><strong style=\"font-size:14px;\"> Activity : ' + 
                    option.text 
                + '</strong></div><div class=\"row\"><i style=\"font-size:11px\"><div class=\"col\"><b> Type: '+ option.type_name +'</b></div><div class=\"col\"><b> Size: '+option.size+'</b></div><div class=\"col\"><b> Class: '+option.class+'</b></div></i></div>'
            );
            return \$option;
        }
    JS
);



$this->registerJs(
    <<<JS
        $('#contract_id').select2({
            dropdownParent: $("#consting_client_contract")
        });
        // $('#item_id').select2({
        //     dropdownParent: $("#consting_client_contract")
        // });
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


// JS code to update select options based on item_id
$kpi = Yii::$app->request->get("kpi", 0);
if ($kpi !== 0) {
    $kpi = 1;
}
$js = <<< JS
        $(document).ready(function() {
            // Initialize Select2
            $('#rate_id').select2({
                dropdownParent: $("#consting_client_contract"),
            });

         
            if ($kpi === 1 && $('#kpi-tab').length) {
                $('#kpi-tab').addClass('active');
                $('#kpi-tab-pane').addClass('active');
                $('#kpi-tab-pane').addClass('show');


                $('#costing-tab').removeClass('active');
                $('#costing-tab-pane').removeClass('active');
                $('#costing-tab-pane').removeClass('show');

                // remove active class from other tabs if needed
            }

        });
    JS;
// Register the JS code
$this->registerJs($js, View::POS_END);
?>





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
                        if (teen === 11) {
                        wordsArr.push('sebelas');
                        } else if (teen === 10) {
                        wordsArr.push('sepuluh');
                        } else {
                        wordsArr.push(words.ones[teen % 10] + ' belas');
                        }
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
                var currencyArray = currency.toString().split(',');

                var amount = parseInt(currencyArray.join(''));

                var currencyWord = '';

                switch (currencyArray[0]) {
                    case 'IDR':
                    currencyWord = 'rupiah';
                    break;
                    default:
                    currencyWord = '';

                }

                var amountWord = rupiahToWords(amount);

                if (amountWord.trim() === '') {
                    amountWord = 'nol';
                }

                var result = 'Total: ' + amountWord + ' ' + currencyWord + ' Rupiah';

                return result;
            }
    JS
);

?>