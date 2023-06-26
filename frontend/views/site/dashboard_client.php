<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Contrack Management System';
?>
<div class="site-index card mt-4">
    <div class="card-header text-center bg-cs1 text-white">
        <h3 class="fw-bold"><?= Yii::$app->user->identity->client->name; ?></h3>
    </div>
    <div class="body-content card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group overflow-auto" style="max-height: 290px;">
                    <li class="list-group-item disabled bg-secondary text-white" aria-disabled="true"><i class="fa-solid fa-file-contract"></i> List Contract</li>
                    <?php
                    foreach ($datacont as $key => $value) {
                        $url = Url::to(['site/index', 'id' => $value->contract_number]);
                        $request = \Yii::$app->request;
                        $id = $request->get('id'); // Mengambil nilai 'id' dari parameter URL
                        $class = '';
                        if ($value->contract_number == $id) {
                            $class = 'active';
                        }

                    ?>
                        <a href="<?= $url ?>" class="list-group-item list-group-item-action <?= $class ?>" aria-current="true">
                            <i class="fa-solid fa-arrow-right"></i> <strong><?= $value->contract_number ?></strong>
                        </a>
                    <?php } ?>


                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <?php if (empty($result)) { ?>
                        <div class="row mb-3 text-center mt-4 ">
                            <div class="col-md-12  text-white">
                                <div class="alert alert-primary" role="alert">
                                    --- Silahkan Pilih kontrak Di List ---
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php foreach ($result as $key => $value) { ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="card-acordion rounded bg-cs1 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#contract_value" aria-expanded="true" aria-controls="contract_value">
                                                <div class="icon me-3">
                                                    <i class="fa-solid fa-vault fa-2xl"></i>
                                                </div>
                                                <div class="content w-100 me-4">
                                                    <div class="text text-white">Contract Value</div>
                                                    <div class="number text-white  text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['contractValueSum']) ? $value['contractValueSum'] : 0); ?></span></div>
                                                </div>
                                                <!-- <strong> Contract Value <?= Yii::$app->formatter->asCurrency($value['contractValueSum'], 'IDR'); ?></strong> -->
                                            </button>
                                        </h2>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="card-acordion rounded bg-cs2 text-white" type="button">
                                                <div class="icon me-3">
                                                    <i class="fa-solid fa-money-bill-trend-up fa-2xl"></i>
                                                </div>
                                                <div class="content w-100 me-4">
                                                    <div class="text text-white">Request Order Commited</div>
                                                    <div class="number text-white  text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['sumReqCommited']) ? $value['sumReqCommited'] : 0); ?></span></div>
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="card-acordion rounded bg-cs3 text-white" type="button">
                                                <div class="icon me-3">
                                                    <i class="fa-solid fa-file-invoice-dollar fa-2xl"></i>
                                                </div>
                                                <div class="content w-100 me-4">
                                                    <div class="text text-white">Request Order Invoiced</div>
                                                    <div class="number text-white  text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['reqInvoiced']) ? $value['reqInvoiced'] : 0); ?></span></div>
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="card-acordion rounded bg-cs4 text-white" type="button">
                                                <div class="icon me-3">
                                                    <i class="fa-solid fa-money-bill-transfer fa-2xl"></i>
                                                </div>
                                                <div class="content w-100 me-4">
                                                <!-- <div class="text text-white">Request Order UnPaid</div> -->
                                                    <!-- <div class="number text-white text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['reqUnpaid']) ? $value['reqUnpaid'] : 0); ?></span></div> -->
                                                    <div class="text text-white">InProgress Request Order</div>
                                                    <div class="number text-white text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['inProgress']) ? $value['inProgress'] : 0); ?></span></div>
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="card-acordion rounded bg-cs1 text-white" type="button">
                                                <div class="icon me-3">
                                                    <i class="fa-solid fa-file-invoice-dollar fa-2xl"></i>
                                                </div>
                                                <div class="content w-100 me-4">
                                                    <div class="text text-white">Request Order Paid</div>
                                                    <div class="number text-white  text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['reqPaid']) ? $value['reqPaid'] : 0); ?></span></div>
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="card-acordion rounded bg-cs5 text-white" type="button">
                                                <div class="icon me-3">
                                                    <i class="fa-solid fa-money-bill-transfer fa-2xl"></i>
                                                </div>
                                                <div class="content w-100 me-4">
                                                    <div class="text text-white">Remaining Contract Value</div>
                                                    <div class="number text-white text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['remaincontvalue']) ? $value['remaincontvalue'] : 0); ?></span></div>
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <?php
                        $dataModel = $value['dataProvidercav']->getModels();
                        foreach ($dataModel as $key => $object) {

                            $activityCode = $object->activity->activity_code;
                            $activityName = $object->activity->activity_name;

                            $activityCode = json_encode($activityCode);
                            $activityName = json_encode($activityName);

                            $budgetsPieData = 0;

                            foreach ($value['budgetsPie'] as $budgetxs) {
                                if (isset($actualsd['activity_id'])) {

                                    if ($object->activity->id == $budgetxs['activity_id']) {
                                        $budgetsPieData = $budgetxs['value'];
                                        // break;
                                    }
                                }
                            }

                            $actualPieData = 0;
                            foreach ($value['actualsData'] as $actualsd) {
                                if (isset($actualsd['activity_id'])) {
                                    if ($object->activity->id == $actualsd['activity_id']) {
                                        $actualPieData = $actualPieData + $actualsd['value'];
                                        // break;
                                    }
                                }
                            }


                            $remaining = 0;
                            $remaining = $object->value - $actualPieData;


                            $jsx = <<<JS
                        var data1 = {
                            labels: ['Budget', 'Used', 'Remaining'],
                            datasets: [{
                                data: [$object->value,$actualPieData,$remaining],
                                backgroundColor: ['#7C96AB', '#00ABB3', '#B46060'],
                            }]
                            };

                            var options1 = {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: $activityName,
                                    },
                                    
                            }
                            };
                            var charts = 'chart' + $activityCode;
                            var ctx1 = document.getElementById(charts).getContext('2d');
                            // Chart.register(ChartDataLabels);

                            new Chart(ctx1, {
                            type: 'pie',
                            data: data1,
                            options: options1
                            });
                        JS;
                            $this->registerJs(new JsExpression($jsx));
                        }

                ?>
            </div>
        </div>
        <div class="row mt-5">
            <!-- <div class="d-flex align-items-center loading-page">
                <strong>Loading...</strong>
                <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
            </div> -->

            <!-- Loading Spinner Wrapper-->
            <div class="loader text-center loading-page">
                <div class="loader-inner">

                    <!-- Animated Spinner -->
                    <div class="lds-roller mb-3">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>

                    <!-- Spinner Description Text [For Demo Purpose]-->
                    <h4 class="text-uppercase font-weight-bold">Loading</h4>
                    <p class="font-italic text-muted">This loading Chart ...</p>
                </div>
            </div>
            <!-- <div class="loading-page">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div> -->
            <?php
                        foreach ($dataModel as $object) { ?>
                <div class="col-md-2 chartData" style="display: none;">
                    <canvas id="chart<?= $object->activity->activity_code ?>"></canvas>
                </div>
            <?php } ?>

        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-cs1 text-white">
                        <h5 class="fw-bold">List Activity</h5>
                    </div>
                    <div class="table-responsive card-body">
                        <table class="table 
                    table-hover	
                    table-borderless
                    align-middle" id="myTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Activity</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php $totalValue = 0; ?>
                                <?php foreach ($value['contractValueData'] as $key => $contval) { ?>
                                    <tr>
                                        <td scope="row"><?= $contval->activity->activity_name ?></td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                IDR<span class="text-end"><?= Yii::$app->formatter->asDecimal($contval->value); ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $totalValue = $totalValue + $contval->value ?>
                                <?php } ?>
                                <tr class="table-dark">
                                    <td scope="row" id="specificRowId">Total</td>
                                    <td>
                                        <div class="d-flex justify-content-between">

                                            IDR <span class="text-end"><?= Yii::$app->formatter->asDecimal($totalValue); ?></span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-cs1 text-white">
                        <h5 class="fw-bold">List Request Order</h5>
                    </div>
                    <div class="table-responsive card-body">
                        <table class="table 
                    table-hover	
                    table-borderless
                    align-middle clientTables">
                            <thead class="table-dark">
                                <tr>
                                    <th>RO Number</th>
                                    <th>SO Number</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php foreach ($value['reqOrder'] as $key => $r) { ?>

                                    <?php
                                    switch ($r->status) {
                                        case '1':
                                            $badgeClass = 'bg-success';
                                            $status = 'RO Received';
                                            break;
                                        case '2':
                                            $badgeClass = 'bg-primary';
                                            $status = 'Work In Progress';
                                            break;
                                        case '3':
                                            $badgeClass = 'bg-info';
                                            $status = 'Work Completed';
                                            break;
                                        case '4':
                                            $badgeClass = 'bg-secondary';
                                            $status = 'Invoiced';
                                            break;
                                        case '9':
                                            $badgeClass = 'bg-warning text-dark';
                                            $status = 'Paid';
                                            break;
                                        case 'Cancelled':
                                            $badgeClass = 'bg-danger';
                                            $status = 'Cancelled';
                                            break;
                                        default:
                                            $badgeClass = 'bg-secondary';
                                            $status = 'Unknown';
                                            break;
                                    }
                                    ?>
                                    <tr class="">
                                        <td scope="row"><?= $r->ro_number ?></td>
                                        <td><?= $r->so_number ?></td>
                                        <!-- <td><?= date('d-m-Y', strtotime($r->start_date)) . " - " . date('d-m-Y', strtotime($r->end_date)) ?></td> -->
                                        <td class="text-center"><?= "<span class=\"badge " . $badgeClass . "\" style=\"padding: 5px 5px;\">" . $status . "</span>"  ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>

<?php
$jsTables = <<<JS
    // Fungsi untuk menyembunyikan loading page dan menampilkan halaman utama
    function showPage() {
      $('.loading-page').fadeOut();
      $('.chartData').fadeIn();

    }

    // Simulasi penundaan selama 3 detik sebelum menampilkan halaman utama
    setTimeout(showPage, 3000);
    $(document).ready(function() {
        $('.clientTables').DataTable({
            "autoWidth": true
        });

        $('#myTable').DataTable({
            "ordering": false,
            "autoWidth": true

        });

    });


JS;
$this->registerJs(new JsExpression($jsTables));

?>
<style>
    .loading-page {
        width: 100%;
        height: 20vh;
        display: flex;
        justify-content: center;
        align-items: center;
        /* background-color: #f8f9fa; */
        background-color: #fff;

    }

    .spinner {
        width: 6rem;
        height: 6rem;
    }

    /* Spinner */
    .lds-roller {
        display: inline-block;
        position: relative;
        width: 64px;
        height: 64px;
    }

    .lds-roller div {
        animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        transform-origin: 32px 32px;
    }

    .lds-roller div:after {
        content: " ";
        display: block;
        position: absolute;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #333;
        margin: -3px 0 0 -3px;
    }

    .lds-roller div:nth-child(1) {
        animation-delay: -0.036s;
    }

    .lds-roller div:nth-child(1):after {
        top: 50px;
        left: 50px;
    }

    .lds-roller div:nth-child(2) {
        animation-delay: -0.072s;
    }

    .lds-roller div:nth-child(2):after {
        top: 54px;
        left: 45px;
    }

    .lds-roller div:nth-child(3) {
        animation-delay: -0.108s;
    }

    .lds-roller div:nth-child(3):after {
        top: 57px;
        left: 39px;
    }

    .lds-roller div:nth-child(4) {
        animation-delay: -0.144s;
    }

    .lds-roller div:nth-child(4):after {
        top: 58px;
        left: 32px;
    }

    .lds-roller div:nth-child(5) {
        animation-delay: -0.18s;
    }

    .lds-roller div:nth-child(5):after {
        top: 57px;
        left: 25px;
    }

    .lds-roller div:nth-child(6) {
        animation-delay: -0.216s;
    }

    .lds-roller div:nth-child(6):after {
        top: 54px;
        left: 19px;
    }

    .lds-roller div:nth-child(7) {
        animation-delay: -0.252s;
    }

    .lds-roller div:nth-child(7):after {
        top: 50px;
        left: 14px;
    }

    .lds-roller div:nth-child(8) {
        animation-delay: -0.288s;
    }

    .lds-roller div:nth-child(8):after {
        top: 45px;
        left: 10px;
    }

    @keyframes lds-roller {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>