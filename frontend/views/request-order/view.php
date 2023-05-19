<?php

use frontend\models\RequestOrderTrans;
use yii\widgets\DetailView;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var frontend\models\Contract $model */
$this->title =  $model->contract->contract_number;
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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
                'value' => Url::to(['request-order-trans/create', 'id' => $model->id, 'client_id'=> $model->client_id]),
                'class' => 'btn btn-success',
                'onclick' => "$('#myModal').modal('show').find('#modalContent').load($(this).attr('value'))",
            ]); ?>
        </div>

        <div class="card-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataRequestOrderTransProvider,
                'filterModel' => $dataRequestOrderTranssearchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'request_order_id',
                    'costing_id',
                    'quantity',
                    'unit_price',
                    //'sub_total',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, RequestOrderTrans $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

    <!-- Trans Modal -->

    <?php Modal::begin([
        'title' => '<h5>Add Request Order Trans</h5>',
        'headerOptions' => ['id' => 'modalHeader'],
        'id' => 'myModal',
    ]); ?>

    <div id='modalContent'></div>

    <?php Modal::end(); ?>
    <!-- End Trans Modal -->
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



                <?php
                $this->registerJs("
                    $('#myModal').on('hidden.bs.modal', function () {
                        $(this).find('form').trigger('reset');
                    });
                    
                    $('#myModal').on('submit', 'form#addCosting', function(e){
                        e.preventDefault();
                        var form = $(this);
                        console.log(form);
                                $('#myModal').modal('hide');

                        // $.ajax({
                        //     url: form.attr('action'),
                        //     method: form.attr('method'),
                        //     data: form.serialize(),
                        //     success: function(response){
                        //         $('#myModal').modal('hide');
                        //         $('#users-container').html(response);
                        //     },
                        // });
                    });
                ");
                ?>





                <style>
                    /* @keyframes pulse {
                        0% {
                            transform: scale(1);
                        }

                        50% {
                            transform: scale(1.1);
                        }

                        100% {
                            transform: scale(1);
                        }
                    }

                    .badge {
                        animation-name: pulse;
                        animation-duration: 1s;
                        animation-iteration-count: infinite;
                        animation: pulse 1s infinite;

                    } */

                    .pulse {
                        /* margin: 100px;
                        display: block;
                        width: 22px;
                        height: 22px;
                        border-radius: 50%;
                        background: rgb(25, 135, 84);
                        cursor: pointer; */
                        box-shadow: 0 0 0 rgba(204, 169, 44, 0.4);
                        animation: pulse 1s infinite;
                    }

                    /* .pulse:hover {
                        animation: none;
                    } */

                    @-webkit-keyframes pulse {
                        0% {
                            transform: scale(1);
                            -webkit-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0.1);
                        }

                        70% {
                            transform: scale(1.1);

                            -webkit-box-shadow: 0 0 0 10px rgba(204, 169, 44, 0);
                        }

                        100% {
                            transform: scale(1);

                            -webkit-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0);
                        }
                    }

                    @keyframes pulse {
                        0% {
                            transform: scale(1);
                            -moz-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0.4);
                            box-shadow: 0 0 0 0 rgba(204, 169, 44, 0.4);
                        }

                        70% {
                            transform: scale(1.1);

                            -moz-box-shadow: 0 0 0 10px rgba(204, 169, 44, 0);
                            box-shadow: 0 0 0 10px rgba(204, 169, 44, 0);
                        }

                        100% {
                            transform: scale(1);

                            -moz-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0);
                            box-shadow: 0 0 0 0 rgba(204, 169, 44, 0);
                        }
                    }
                </style>
                <!--/row-->
                <!-- timeline item 2 -->
                <!-- <div class="row">
                    <div class="col-auto text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col border-end">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge rounded-pill bg-success">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col border-end">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col py-2">
                        <div class="card border-success shadow">
                            <div class="card-body">
                                <div class="float-right text-success">Tue, Jan 10th 2019 8:30 AM</div>
                                <h4 class="card-title text-success">Day 2 Sessions</h4>
                                <p class="card-text">Sign-up for the lessons and speakers that coincide with your course syllabus. Meet and greet with instructors.</p>
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-target="#t2_details" data-bs-toggle="collapse">Show Details ▼</button>
                                <div class="collapse border" id="t2_details">
                                    <div class="p-2 font-monospace">
                                        <div>08:30 - 09:00 Breakfast in CR 2A</div>
                                        <div>09:00 - 10:30 Live sessions in CR 3</div>
                                        <div>10:30 - 10:45 Break</div>
                                        <div>10:45 - 12:00 Live sessions in CR 3</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!--/row-->
                <!-- timeline item 3 -->
                <!-- <div class="row">
                    <div class="col-auto text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col border-end">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge rounded-pill bg-light border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col border-end">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col py-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right text-muted">Wed, Jan 11th 2019 8:30 AM</div>
                                <h4 class="card-title">Day 3 Sessions</h4>
                                <p>Shoreditch vegan artisan Helvetica. Tattooed Codeply Echo Park Godard kogi, next level irony ennui twee squid fap selvage. Meggings flannel Brooklyn literally small batch, mumblecore PBR try-hard kale chips. Brooklyn vinyl lumbersexual
                                    bicycle rights, viral fap cronut leggings squid chillwave pickled gentrify mustache. 3 wolf moon hashtag church-key Odd Future. Austin messenger bag normcore, Helvetica Williamsburg sartorial tote bag distillery Portland before
                                    they sold out gastropub taxidermy Vice.</p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!--/row-->
                <!-- timeline item 4 -->
                <!-- <div class="row">
                    <div class="col-auto text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col border-end">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge rounded-pill bg-light border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col py-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-right text-muted">Thu, Jan 12th 2019 11:30 AM</div>
                                <h4 class="card-title">Day 4 Wrap-up</h4>
                                <p>Join us for lunch in Bootsy's cafe across from the Campus Center.</p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!--/row-->
            </div>
            <!--container-->
        </div>