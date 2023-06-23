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
                <div class="row mt-2">
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
                                            <button class="accordion-button rounded bg-cs1 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#contract_value" aria-expanded="true" aria-controls="contract_value">
                                                <div class="icon me-3">
                                                    <i class="fa-solid fa-vault fa-2xl"></i>
                                                </div>
                                                <div class="content w-100 me-4">
                                                    <div class="text text-white">Contract Value</div>
                                                    <div class="number text-white  text-start fw-bold">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['contractValueSum']) ? $value['contractValueSum'] : 0); ?></span></div>
                                                </div>
                                                <!-- <strong> Contract Value <?= Yii::$app->formatter->asCurrency($value['contractValueSum'], 'IDR'); ?></strong> -->
                                            </button>
                                        </h2>
                                        <div id="contract_value" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped
                                                            table-hover	
                                                            table-borderless
                                                            table-primary
                                                            align-middle">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Activity</th>
                                                                <th>Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-group-divider">
                                                            <?php $totalValue = 0; ?>
                                                            <?php foreach ($value['contractValueData'] as $key => $contval) { ?>
                                                                <tr class="table-primary">
                                                                    <td scope="row"><?= $contval->activity->activity_name ?></td>
                                                                    <td><?= Yii::$app->formatter->asCurrency($contval->value, 'IDR'); ?></td>
                                                                </tr>
                                                                <?php $totalValue = $totalValue + $contval->value ?>
                                                            <?php } ?>
                                                            <tr class="table-light">
                                                                <td scope="row">Total</td>
                                                                <td><?= Yii::$app->formatter->asCurrency($totalValue, 'IDR'); ?></td>
                                                            </tr>
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <div class="number text-white  text-start fw-bold">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['sumReqCommited']) ? $value['sumReqCommited'] : 0); ?></span></div>
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
                                                    <div class="number text-white  text-start fw-bold">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['reqInvoiced']) ? $value['reqInvoiced'] : 0); ?></span></div>
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
                                                    <div class="text text-white">Request Order Vs Actual</div>
                                                    <div class="number text-white text-start fw-bold">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['reqroactual']) ? $value['reqroactual'] : 0); ?></span></div>
                                                </div>
                                            </button>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <div class="rounded d-flex justify-content-center bg-cs5">
                                                <div class="bg-cs5 text-white d-flex align-items-center">
                                                    <div class="icon me-3">
                                                        <i class="fa-solid fa-sack-dollar fa-lg"></i>
                                                    </div>
                                                    <div class="content">
                                                        <div class="text text-white text-center">Remaining Contract Value</div>
                                                        <div class="number text-white text-center fw-bold">IDR <span class="fs-3"><?= Yii::$app->formatter->asDecimal(!empty($value['remaincontvalue']) ? $value['remaincontvalue'] : 0); ?></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header text-center bg-cs1">
                                        <h5 class="fw-bold text-white">Contract Value / Remaining</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                </div>

                <?php
                        $data = $value['dataProvidercav']->getModels();
                        foreach ($data as $key => $object) {

                            $activityCode = $object->activity->activity_code;
                            $activityName = $object->activity->activity_name;

                            $activityCode = json_encode($activityCode);
                            $activityName = json_encode($activityName);

                            $budgetsPieData = 0;

                            foreach ($value['budgetsPie'] as $budgetxs) {
                                if (isset($actualsd['activity_id'])) {

                                    if ($object->activity->id == $budgetxs['activity_id']) {
                                        $budgetsPieData = $budgetxs['value'];
                                        break;
                                    }
                                }
                            }

                            $actualPieData = 0;
                            foreach ($value['actualsData'] as $actualsd) {
                                if (isset($actualsd['activity_id'])) {
                                    if ($object->activity->id == $actualsd['activity_id']) {
                                        $actualPieData = $budgetxs['value'];
                                        break;
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
                                backgroundColor: ['#7C96AB', '#00ABB3', '#B31312']
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
                            new Chart(ctx1, {
                            type: 'pie',
                            data: data1,
                            options: options1
                            });
                        JS;
                            $this->registerJs(new JsExpression($jsx));
                        }

                ?>
            <?php } ?>
            </div>
        </div>
        <div class="row mt-5">
            <?php $data = $value['dataProvidercav']->getModels(); ?>
            <?php foreach ($data as $object) { ?>
                <div class="col-md-2">
                    <canvas id="chart<?= $object->activity->activity_code ?>"></canvas>
                </div>
            <?php } ?>
        </div>
    </div>
</div>