<?php

use frontend\models\Costing;
use frontend\models\RequestOrder;
use frontend\models\RequestOrderTrans;
use yii\bootstrap5\ActiveForm;
use yii\widgets\DetailView;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\Contract $model */
$this->title =  $model->contract->contract_number;
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);

$this->registerJs(<<<JS
    $('#costing_idx').select2({
        dropdownParent: $('#myModal')
    });

    $('#costing_idx').on('change', function() {
        var selectedOption = $(this).find(':selected');
        var costingId = selectedOption.val();
        $.ajax({
            url: '/costing/getprice',
            method: 'GET',
            data: { costingId: costingId },
            dataType: 'json',
            success: function(response) {
                console.log(response.price);
                $('#unit_pricex').val(response.price);
                $('#curency_format').val(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(response.price));

                
            },
            error: function() {
                console.log('An error occurred while fetching the price.');
            }
        });
    });

    $('#quantity2').on('keyup', function() {
        // get the quantity and unit price values
        var quantityInput = $('#quantity2');
        var unitPriceInput = $('#unit_pricex');
        var totalPriceInput = $('#total_price');
        var total_curency_format = $('#total_curency_format');
        // display the total price in the input field
        var quantity = Number(quantityInput.val());
        var currencyString = unitPriceInput.val();
        var unitPrice = currencyString; // 10000


        // calculate the total price
        var totalPrice = quantity * unitPrice;
        // display the total price in the input field
        totalPriceInput.val(totalPrice);
        total_curency_format.val(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalPrice));
        
    });

    $('#costing_idx').select2({
            dropdownParent: $("#modalHeader"),
            // minimumInputLength: 2,
            ajax: {
                url: 'select2-get',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        id: $model->id,

                    };
                },
                processResults: function(data, params) {

                    return {
                    results: $.map(data.results, function (obj) {
                        return {id: obj.id, text: obj.activity_name, type_name: obj.type_name, size: obj.size,class: obj.class,price: obj.price, 'data-customer': obj.id};
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
            // var itemId = $(this).val();
            // // Make an AJAX request to fetch select options based on item_id
            // $.ajax({
            //     url: '/costing/fetch-options-unit-rate', // Replace with the actual URL to fetch select options
            //     type: 'GET',
            //     data: {item_id: itemId},
            //     dataType: 'json',
            //     success: function(response) {
            //         // Clear existing options
            //         $('#rate_id').empty();

            //         $('#rate_id').append($('<option></option>').attr('value', '').text('Select unit Rate...'));

            //         // Add new options based on the response
            //         $.each(response, function(key, value) {
            //             $('#rate_id').append($('<option></option>').attr('value', key).text(value));
            //         });

            //         // Refresh Select2 to reflect the updated options
            //         $('#rate_id').trigger('change');
            //     },
            //     error: function() {
            //         console.log('Error occurred while fetching select options.');
            //     }
            // });
        });

        function templateResult(option) {
            var \$option = $(
                '<div><strong style=\"font-size:14px;\"> Activity : ' + 
                    option.text 
                + '</strong></div><div class=\"row\"><i style=\"font-size:11px\"><div class=\"col\"><b> Type: '+ option.type_name +'</b></div><div class=\"col\"><b> Size: '+option.size+'</b></div><div class=\"col\"><b> Class: '+option.class+'</b></div><div class=\"col\"><b> Price: '+option.price+'</b></div></i></div>'
            );
            return \$option;
        }
JS);

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
<div class="contract-view">
    <div class="card">
        <h5 class="card-header bg-secondary text-white">#<?= Html::encode($this->title) ?></h5>
        <div class="card-body">
            <!-- <p>
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
                    'contract.contract_number',
                    'client.name',
                    'ro_number',
                    'so_number',

                    [
                        'label' => 'Contract Detail',
                        'format' => 'raw',
                        'value' => function ($model) {

                            $badgeClass = 'bg-secondary';
                            switch ($model->status) {
                                case '1':
                                    $badgeClass = 'bg-success';
                                    $status = 'OPEN';
                                    break;
                                case '9':
                                    $badgeClass = 'bg-warning text-dark';
                                    $status = 'CLOSE';
                                    break;
                                case 'Cancelled':
                                    $badgeClass = 'bg-danger';
                                    break;
                            }
                            $activitys = "";
                            // foreach ($model->requestOrderActivities as $key => $value) {
                            //     $activitys .= $value->activity_code->activity_name ;
                            //     // print_r($value->activity_code);die;
                            // }

                            $activities = array_map(function ($activity) {
                                return $activity->activityCode->activity_name;
                            }, $model->requestOrderActivities);
                            $activitys =  implode(', ', $activities);

                            return "<strong style=\"margin-right: 50px;\">Contract Type</strong>  
                    <span class=\"badge bg-primary\" style=\"padding: 5px 10px;margin-right: 10px;\">$model->contract_type</span>
                    <strong style=\"margin-right: 30px;\">Contract Status</strong>
                    <span class=\"badge " . $badgeClass . "\" style=\"padding: 5px 5px;\">" . $status . "</span>
                    <br>
                    <strong style=\"
                    margin-right: 30px;\">Contract Activity</strong><span class=\"badge bg-warning text-dark mr-5\">$activitys</span>";
                        }
                    ],
                    [
                        'label' => 'Contract Duration',
                        'value' => function ($model) {
                            return date('d-m-Y', strtotime($model->start_date)) . ' To ' . date('d-m-Y', strtotime($model->end_date));
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d-m-Y']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'php:d-m-Y']
                    ],
                ],
            ]) ?>

        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"># Service To Provide <?= Html::encode($this->title) ?> </h5>
            <?= Html::button('<i class="glyphicon glyphicon-plus"></i> Create', [
                // 'value' => Url::to(['request-order-trans/create', 'id' => $model->id, 'client_id'=> $model->client_id,'contract_number'=> $model->contract->contract_number]),
                'class' => 'btn btn-success',
                'onclick' => "$('#myModal').modal('show').find('#modalContent').load()",
            ]); ?>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <?php Pjax::begin([
                    'id' => 'my-pjax',
                ]); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataRequestOrderTransProvider,
                    'filterModel' => $dataRequestOrderTranssearchModel,
                    'filterPosition' => false, // this line removes the filter header\
                    'showFooter' => true, // this line enables the footer row
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'costing_id',
                            'label' => 'Costing',
                            'filter' => false,
                            'format' => 'raw',
                            'value' => function ($model) {
                                $activityName = strtoupper($model->costing->item->masterActivityCode->activity_name);
                                $typeName = strtoupper($model->costing->item->itemType->type_name);
                                $class = strtoupper($model->costing->item->class);
                                $size = strtoupper($model->costing->item->size);

                                $rateName = strtoupper($model->costing->unitRate->rate_name);
                                // $price = number_format($model->price, 0, ',', '.');
                                // return "{$activityName} - {$typeName} - {$rateName} (Rp {$price})";;
                                return "- Activity : {$activityName}<br> - Type : {$typeName}<br> - Class: {$class}<br> - Size: {$size}<br> - Rate: {$rateName}";
                            }
                        ],
                        // 'requestOrder.ro_number',
                        // 'quantity',
                        [
                            'attribute' => 'quantity',
                            'filter' => false,
                        ],

                        // 'unit_price',
                        // 'sub_total',
                        [
                            'attribute' => 'unit_price',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asCurrency($model->unit_price, 'IDR');
                            }
                        ],
                        [
                            'attribute' => 'sub_total',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asCurrency($model->sub_total, 'IDR');
                            },
                            'footer' => RequestOrder::getTotal($dataRequestOrderTransProvider->models, 'sub_total'),

                        ],
                        [
                            'class' => ActionColumn::className(),
                            'template' => '{delete}',
                            'urlCreator' => function ($action, RequestOrderTrans $model, $key, $index, $column) {
                                return Url::toRoute(['/request-order-trans/delete', 'id' => $model->id, 'ro' => \Yii::$app->request->get('id')]);
                            }
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>

    </div>

    <div class="card mt-5">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">#<?= Html::encode($this->title) ?> </h5>
            <a href="<?= Url::toRoute(['activity-contract/create', 'id' => $model->id]); ?>"><button class="btn btn-sm btn-primary">Add Activity</button></a>
        </div>

        <div class="card-body">
            <div class="container py-2">
                <h2 class="font-weight-light text-center text-muted py-3">Timeline</h2>
                <!-- timeline item 1 -->
                <?php
                foreach ($model->activityContract as $index => $event) : ?>

                    <?php
                    if ($event['status'] == 2) {
                        $textColor = 'text-success';
                        $bg = 'bg-success animate__animated animate__pulse pulse';
                        $border = 'border border-3 border-success';
                    } elseif ($event['status'] == 1) {
                        $textColor = '';
                        $bg = 'bg-light border';
                        $border = '';
                    } else {
                        $textColor = 'text-muted';
                        $bg = 'bg-light border';
                        $border = '';
                    }
                    ?>

                    <div class="row">
                        <!-- timeline item left dot -->
                        <div class="col-auto text-center flex-column d-none d-sm-flex">
                            <div class="row h-50">
                                <div class="col <?= $index == 0 ? '' : 'border-end' ?>">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                            <h5 class="m-2">
                                <span class="badge rounded-pill <?= $bg ?>">&nbsp;</span>
                            </h5>
                            <div class="row h-50">
                                <div class="col border-end">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                        </div>
                        <!-- timeline item event content -->
                        <div class="col py-2">
                            <div class="card <?= $border ?> ">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="float-right <?= $textColor ?>"><?= date('D, jS M Y g:i A', strtotime($event['created_date'])); ?></div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="<?= Url::toRoute(['activity-contract/update/', 'id' => $event['id'], 'contract_id' => $model->id]); ?>">Edit</a></li>
                                                <li><a class="dropdown-item" data-confirm="Are you sure you want to delete this item?" data-method="post" href="<?= Url::toRoute(['activity-contract/delete/', 'id' => $event['id']]); ?>">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <h4 class="card-title <?= $textColor ?>"><?= $event['activity'] ?></h4>
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-target="#t<?= $event['id']  ?>_details" data-bs-toggle="collapse">Show Details ▼</button>

                                    <div class="collapse border" id="t<?= $event['id']  ?>_details">
                                        <div class="p-2 font-monospace">
                                            <p class="card-text"><?= $event['description'] ?></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
            <!--container-->
        </div>

        <?php
        ?>



        <!-- Trans Modal -->

        <?php Modal::begin([
            'title' => '<h5>Add Request Order Trans</h5>',
            'headerOptions' => ['id' => 'modalHeader'],
            'id' => 'myModal',
        ]); ?>

        <div id='modalContent'>

            <?php $form = ActiveForm::begin(['id' => 'addCosting']); ?>
            <?= $form->field($dataRequestOrderTransModel, 'contract_number')->textInput(['value' => $model->contract->contract_number, 'disabled' => true]) ?>
            <?php // $form->field($dataRequestOrderTransModel, 'costing_name')->dropDownList(['1' => 1], ['id' => 'costing_name', 'class' => "costings", 'prompt' => 'Select unit Rate...']) 
            ?>
            <?= $form->field($dataRequestOrderTransModel, 'costing_id')->dropDownList([], ['id' => 'costing_idx', 'class' => 'form-control form-select', 'prompt' => 'Select a Costing ...', 'style' => 'width:100%',])->label('Costing') ?>

            <?php
            // $form->field($dataRequestOrderTransModel, 'costing_id')->dropDownList(
            //     ArrayHelper::map(
            //         Costing::find()
            //             ->joinWith('item')
            //             ->where(['client_id' => $model->client_id])
            //             ->andWhere(['IN', 'item.master_activity_code', $activityArray]) // add any other conditions here
            //             ->all(),
            //         'id',
            //         function ($costing) {
            //             $activityName = strtoupper($costing->item->masterActivityCode->activity_name);
            //             $typeName = strtoupper($costing->item->itemType->type_name);
            //             $size = strtoupper($costing->item->size);
            //             $class = strtoupper($costing->item->class);

            //             $rateName = strtoupper($costing->unitRate->rate_name);
            //             $price = number_format($costing->price, 0, ',', '.');

            //             return "{$activityName} - {$typeName} - {$class} - {$size} - {$rateName} (Rp {$price})";
            //         }
            //     ),
            //     ['id' => 'costing_idx', 'class' => 'form-control form-select', 'style' => 'width: 100%"', 'prompt' => 'Select a Costing ...']
            // )->label('Costing');
            ?>

            <?= $form->field($dataRequestOrderTransModel, 'curency_format')->textInput(['id' => 'curency_format', 'maxlength' => true, 'readonly' => true]) ?>


            <?= $form->field($dataRequestOrderTransModel, 'quantity')->textInput(['id' => 'quantity2']) ?>


            <?= $form->field($dataRequestOrderTransModel, 'total_curency_format')->textInput(['id' => 'total_curency_format', 'maxlength' => true]) ?>


            <?= $form->field($dataRequestOrderTransModel, 'request_order_id')->hiddenInput(['value' => $model->id])->label(false) ?>
            <?= $form->field($dataRequestOrderTransModel, 'unit_price')->hiddenInput(['id' => 'unit_pricex', 'maxlength' => true, 'readonly' => true])->label(false) ?>
            <?= $form->field($dataRequestOrderTransModel, 'sub_total')->hiddenInput(['id' => 'total_price', 'maxlength' => true])->label(false) ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <?php Modal::end(); ?>
        <!-- End Trans Modal -->
        <?php
        $this->registerJs(<<<JS
            $('#myModal').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
            });
            
            $('#myModal').on('submit', 'form#addCosting', function(e){
                e.preventDefault();
                var form = $(this);
                // $('#myModal').modal('hide');
                console.log(form.attr('method'));
                $.ajax({
                    url: '/request-order-trans/create',
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response){
                        console.log(response);
                        if(response.success){
                            $('#myModal').modal('hide');
                            Swal.fire({
                            icon: 'success',
                            title: 'Data has been saved',
                            showConfirmButton: true,
                            timer: 1500
                            });
                        $.pjax.reload({container:'#my-pjax'});
                        }else{
                            alert('Failed Saved');

                        }
                    },
                });
            });
        JS);
        ?>