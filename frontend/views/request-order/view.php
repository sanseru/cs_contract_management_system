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
                        return {id: obj.id, text: obj.activity_name, type_name: obj.type_name, size: obj.size,class: obj.class,price: obj.price,unitrate: obj.unitrate, 'data-customer': obj.id};
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
                    return data.text+ ' - ' + data.unitrate + ' - ' + data.type_name + ' - ' + data.size + ' - ' + data.class;

                }else{

                return data.text;

                }
            }
        }).on('change', function() {

        });

        function templateResult(option) {
            var \$option = $(
                '<div><strong style=\"font-size:14px;\"> Activity : ' + 
                    option.text 
                + '</strong></div><div class=\"row\"><i style=\"font-size:11px\"><div class=\"col\"><b> Type: '+ option.type_name +'</b></div><div class=\"col\"><b> Rate: '+option.unitrate+'</b></div><div class=\"col\"><b> Size: '+option.size+'</b></div><div class=\"col\"><b> Class: '+option.class+'</b></div><div class=\"col\"><b> Price: '+option.price+'</b></div></i></div>'
            );
            return \$option;
        }

    $(document).on('click', '.show-button', function() {
    var id = $(this).data('id');
        $.ajax({
            url: '/request-order-trans/show-details',
            type: 'POST',
            data: {id: id},
            success: function(response) {
                // console.log(response.orderDetails.table)
                $("#insertHere").html(response.orderDetails.table);
                $('#tablesed').DataTable({
                    "autoWidth": true
                });

                $('html, body').animate({
                scrollTop: $("#card-details").offset().top
            }, 1000); // 1000 is the duration of the animation in milliseconds

            },
            error: function() {
                alert('Error occurred while processing the request.');
            }
        });
    });

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
                        [
                            'attribute' => 'quantity',
                            'filter' => false,
                        ],
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
                            'template' => '{show} {delete} ',
                            'buttons' => [
                                'show' => function ($url, $model, $key) {
                                    return Html::button('<i class="fa-solid fa-table"></i>', [
                                        'class' => 'btn btn-info btn-sm show-button text-white',
                                        'data-id' => $model->id,
                                    ]);
                                },
                            ],
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

    <div class="card mt-5" id="card-details">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">#Detail Service To Provide </h5>
        </div>
        <div class="card-body" id="insertHere">

        </div>
    </div>




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
                var submitButton = $(this).find(':submit');
                submitButton.prop('disabled', true);
                submitButton.html('Processing <i class="fa fa-spinner fa-spin"></i>');
                var form = $(this);
                $.ajax({
                    url: '/request-order-trans/create',
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response){
                        // console.log(response);
                        if(response.success){
                            $('#myModal').modal('hide');
                            Swal.fire({
                            icon: 'success',
                            title: 'Data has been saved',
                            showConfirmButton: true,
                            timer: 1500
                            });
                            $("#costing_idx").val(null).trigger("change"); // reset to empty state
                            submitButton.prop('disabled', false);
                            submitButton.html('Save');
                        $.pjax.reload({container:'#my-pjax'});
                        }else{
                            alert('Failed Saved');
                            submitButton.prop('disabled', false);
                            submitButton.html('Save');

                        }
                    },
                });
            });
        JS);
    ?>


    <!-- Modals -->


    <!-- Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="resv-number" class="form-label">RESV NUMBER</label>
                                    <input type="text" class="form-control" id="resv-number" name="resv-number" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ce-year" class="form-label">CE YEAR</label>
                                    <input type="text" class="form-control" autocomplete="off" id="ce-year" name="ce-year">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cost-estimate" class="form-label">COST ESTIMATE</label>
                                    <input type="text" class="form-control" autocomplete="off" id="cost-estimate" name="cost-estimate">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ro-number" class="form-label">RO NUMBER</label>
                                    <input type="text" class="form-control" autocomplete="off" id="ro-number" name="ro-number">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="material-incoming-date" class="form-label">MATERIAL INCOMING DATE</label>
                                    <input type="date" class="form-control" autocomplete="off" id="material-incoming-date" name="material-incoming-date">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ro-start" class="form-label">RO START</label>
                                    <input type="date" class="form-control" autocomplete="off" id="ro-start" name="ro-start">
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label for="ro-end" class="form-label">RO END</label>
                                    <input type="date" class="form-control" autocomplete="off" id="ro-end" name="ro-end">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="urgency" class="form-label">URGENCY</label>
                            <input type="text" class="form-control" autocomplete="off" id="urgency" name="urgency">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty" class="form-label">QTY</label>
                                    <input type="number" class="form-control" autocomplete="off" id="qty" name="qty">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id-valve" class="form-label">ID VALVE</label>
                                    <input type="text" class="form-control" autocomplete="off" id="id-valve" name="id-valve">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="size" class="form-label">SIZE</label>
                                    <input type="text" class="form-control" autocomplete="off" id="size" name="size">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="class" class="form-label">CLASS</label>
                                    <input type="text" class="form-control" autocomplete="off" id="class" name="class">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="equipment-type" class="form-label">EQUIPMENT TYPE</label>
                            <input type="text" class="form-control" autocomplete="off" id="equipment-type" name="equipment-type">
                        </div>
                        <div class="mb-3">
                            <label for="sow" class="form-label">SOW</label>
                            <input type="text" class="form-control" autocomplete="off" id="sow" name="sow">
                        </div>
                        <input type="hidden" class="form-control" id="rotrans_id" name="rotrans_id">
                        <input type="hidden" class="form-control" id="roid" name="roid" value="<?= $model->id ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    $js = <<<JS
        $(document).on('click', '#btn_item', function() {
            var id = $(this).data('id');
            $('#rotrans_id').val(id);
        });

        $('#addItemModal form').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/request-order-trans/add-item',
                data: $(this).serialize(),
                success: function(response) {
                    // handle success response
                    console.log(response);
                    $('#addItemModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    // handle error response
                    console.log(xhr.responseText);
                }
            });
        });


        $('#exampleModal form').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);
        $.ajax({
            url: '/request-order-trans/insert-update-item',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Handle the success    response
                console.log(response);
            },
            error: function(xhr) {
                // Handle the error response
                console.log(xhr.responseText);
            }
        });
    });

    JS;
    $this->registerJs($js);



    ?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Items</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id='myFormItemUpdate'>
                </form>
                </div>

            </div>
        </div>
    </div>


    <?php
    $js = <<<JS

    $(document).on('click', '.editItems', function() {
        var itemId = $(this).data('id');
        var reqId = $(this).data('reqid');
            console.log(itemId,reqId);
        // Create an AJAX request to post the data
        $.ajax({
            url: '/request-order-trans/update-item',
            type: 'POST',
            data: { itemId: itemId, reqId: reqId },
            success: function(data) {
            $('#myFormItemUpdate').html(data.form);
            // Handle the response from the server
            // console.log(data);
            }
        });
    });
    JS;
    $this->registerJs($js);


    ?>