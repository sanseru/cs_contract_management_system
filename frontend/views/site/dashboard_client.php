<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Contrack Management System';
?>

<div class="site-index card mt-4">
    <div class="card-header text-center bg-formbarblue text-white">
        <h3 class="fw-bold"><?= Yii::$app->user->identity->client->name; ?></h3>
    </div>
    <div class="body-content card-body">
        <div class="row">
            <div class="col-lg-3 col-md-12 my-2">
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
            <div class="col-lg-9 col-md-12">
                <?php if (empty($result)) { ?>
                    <div class="row mb-3 text-center mt-2">
                        <div class="col-md-12 text-white">
                            <div class="alert alert-primary" role="alert">
                                --- Silahkan Pilih kontrak Di List ---
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php foreach ($result as $key => $value) { ?>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-12 my-2">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="card-acordion rounded bg-blue1 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#contract_value" aria-expanded="true" aria-controls="contract_value">
                                            <div class="icon me-3">
                                                <i class="fa-solid fa-vault fa-2xl"></i>
                                            </div>
                                            <div class="content w-100 me-4">
                                                <div class="text text-white">Contract Value</div>
                                                <div class="number text-white text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['contractValueSum']) ? $value['contractValueSum'] : 0); ?></span></div>
                                            </div>
                                        </button>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="card-acordion rounded bg-blue2 text-white" type="button" data-bs-toggle="modal" data-bs-target="#modalCommited" data-contr="<?= Yii::$app->request->get('id'); ?>" data-url="commited">
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
                        <div class="col-md-6 my-2">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="card-acordion rounded bg-blue3 text-white" type="button">
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
                        <div class="col-md-6 my-2">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="card-acordion rounded bg-blue4 text-white" type="button">
                                            <div class="icon me-3">
                                                <i class="fa-solid fa-file-invoice-dollar fa-2xl"></i>
                                            </div>
                                            <div class="content w-100 me-4">
                                                <div class="text text-white">InProgress Request Order</div>
                                                <div class="number text-white text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['inProgress']) ? $value['inProgress'] : 0); ?></span></div>
                                                <!-- <div class="text text-white">Request Order Paid</div>
                                            <div class="number text-white  text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['reqPaid']) ? $value['reqPaid'] : 0); ?></span></div> -->
                                            </div>
                                        </button>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 my-2">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="card-acordion rounded bg-blue5 text-white" type="button">
                                            <div class="icon me-3">
                                                <i class="fa-solid fa-money-bill-transfer fa-2xl"></i>
                                            </div>
                                            <div class="content w-100 me-4">
                                                <div class="text text-white">Request Order UnPaid</div>
                                                <div class="number text-white text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['reqUnpaid']) ? $value['reqUnpaid'] : 0); ?></span></div>
                                                <!-- <div class="text text-white">InProgress Request Order</div>
                                            <div class="number text-white text-start fw-bold mt-3">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['inProgress']) ? $value['inProgress'] : 0); ?></span></div> -->
                                            </div>
                                        </button>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 my-2">
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
                            backgroundColor: ['#1889b5', '#68cbe0', '#454545'],
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

        <div class="row mt-3 mb-5">
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
                <div class="col-lg-2 col-md-4 chartData" style="display: none;" data-id="<?= $object->activity->id ?>" data-noreq="<?= \Yii::$app->request->get('id') ?>">
                    <canvas id="chart<?= $object->activity->activity_code ?>"></canvas>
                </div>
            <?php } ?>

        </div>

        <div class="row">
            <div class="col-lg-6 col-md-12 my-2">
                <div class="card">
                    <div class="card-header text-center bg-formbarblue text-white">
                        <h5 class="fw-bold">List Activity</h5>
                    </div>
                    <div class="table-responsive card-body">
                        <table class="table table-hover	table-borderless align-middle" id="myTable">
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
            <div class="col-lg-6 col-md-12 my-2">
                <div class="card">
                    <div class="card-header text-center bg-formbarblue text-white">
                        <h5 class="fw-bold">List Request Order</h5>
                    </div>
                    <div class="table-responsive card-body">
                        <table class="table table-hover	table-borderless align-middle clientTables">
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

<!-- Modal -->
<div class="modal fade" id="modalCommited" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="commitedBody">
                Downloading data...
                <p>Please wait or re-open the chart window...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCommited2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pieData">
                Downloading data...
                <p>Please wait or re-open the chart window...</p>
            </div>
        </div>
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
        var myModal = new bootstrap.Modal(document.getElementById('modalCommited2'))

        $('.clientTables').DataTable({
            "autoWidth": true,
            "lengthMenu": [ 10 ],
        });

        $('#myTable').DataTable({
            "ordering": false,
            "autoWidth": true,
            "lengthChange": false,
            "info": false,
        });

        // function chartpie(params) {
        //     myModal.show();
        //     alert(params);
        // }

        /* Generate pie chart */
        $('.chartData').click(function() {
            var html = 'Fetch Data...<p>If Not Show Please Close And Open Again...</p>';
            $('#pieData').html(html);

            /* Get the data-id attribute value */
            var dataId = $(this).data('id');
            var noReq = $(this).data('noreq');
            myModal.show();

            var url = '/site/chart-data';
        
            /* Lakukan permintaan AJAX untuk mendapatkan konten modal */
            $.ajax({
                url: url,
                type: 'GET',
                data: { id: dataId, noReq: noReq }, // Include the data-contr value in the AJAX request
                dataType: 'html',
                success: function(response) {
                    // Render konten modal ke dalam modal-body
                    $('#pieData').html(response);
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan jika ada
                    console.error(error);
                }
            });
        });

        $('#modalCommited').on('show.bs.modal', function(event) {
            var contr = event.relatedTarget.getAttribute('data-contr');
            var url = event.relatedTarget.getAttribute('data-url');

            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var modal = $(this);

            // Ambil URL tautan yang akan di-render
            if(url == 'commited'){
                var url = '/site/modal-commited';
            }

            // Lakukan permintaan AJAX untuk mendapatkan konten modal
            $.ajax({
                url: url,
                type: 'GET',
                data: { contr: contr }, // Include the data-contr value in the AJAX request
                dataType: 'html',
                success: function(response) {
                    console.log(response);
                    // Render konten modal ke dalam modal-body
                    modal.find('#commitedBody').html(response);
                },
                error: function(xhr, status, error) {
                    // Tangani kesalahan jika ada
                    console.error(error);
                }
            });
        });
    });
JS;
$this->registerJs(new JsExpression($jsTables));
?>