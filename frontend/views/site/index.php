<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\web\JsExpression;

$this->title = 'Contrack Management System';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 bg-cs1 rounded text-white hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-user fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">CLIENTS</div>
                        <div class="number text-white"><?= $client ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 text-white rounded bg-cs2 hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-file-contract fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">CONTRACTS</div>
                        <div class="number text-white"><?= $contractCount ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 text-white rounded bg-cs4 hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-list-check fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">REQUEST ORDER ON PROGRESS</div>
                        <div class="number text-white"><?= $requestProgress ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 text-white rounded bg-cs2 hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-circle-check fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">REQUEST ORDER COMPLETED</div>
                        <div class="number text-white"><?= $requestCompleted ?></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 text-white rounded bg-cs3 hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-file-invoice-dollar fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">REQUEST ORDER INVOICED</div>
                        <div class="number text-white"><?= $requestInvoiced ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 text-white rounded bg-cs5 hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-receipt fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">REQUEST ORDER PAID</div>
                        <div class="number text-white"><?= $requestPaid ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 text-white rounded bg-cs4 hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-file-invoice-dollar fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">INVOICED</div>
                        <div class="number-curency text-white mt-2"><?= Yii::$app->formatter->asCurrency($invoiced, 'IDR') ?></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box-4 text-white rounded bg-cs1 hover-expand-effect">
                    <div class="icon">
                        <i class="fa-solid fa-receipt fa-2xl"></i>
                    </div>
                    <div class="content">
                        <div class="text text-white fs-6">PAID</div>
                        <div class="number-curency text-white mt-2"><?= Yii::$app->formatter->asCurrency($paid, 'IDR')  ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart"></canvas>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
$jsTables = <<<JS

    Chart.register(ChartDataLabels);


    var data = {
      labels: ['RO Received', 'Work In Progress', 'Work Completed','Invoiced','Paid'],
      datasets: [{
        data: [$requestreceive, $requestWorkinProgress, $requestCompleted, $requestInvoiced, $requestPaid],
        backgroundColor: ['#567189', '#7B8FA1', '#CFB997','#FAD6A5','#FF8B13'],
        datalabels: {
        anchor: 'center',
        backgroundColor: null,
        borderWidth: 0,
        backgroundColor: ['#525FE1'],
        color: 'white',
        borderColor: 'white',
        borderRadius: 25,
        borderWidth: 2,
        font: {
          weight: 'bold'
        },
        padding: 6,
        
      },
      }]
    };

    var config = {
      type: 'doughnut',
      data: data,
      options: {
        datalabels: {
            display: true,
        },
      },

    };

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, config);
JS;
$this->registerJs(new JsExpression($jsTables));

?>