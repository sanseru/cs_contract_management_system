<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Contrack Management System';
?>
<div class="site-index card mt-4">
    <div class="card-header text-center bg-info-subtle">
        <h3 class="fw-bold"><?= Yii::$app->user->identity->client->name; ?></h3>
    </div>
    <div class="body-content card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <li class="list-group-item disabled bg-secondary text-white" aria-disabled="true"><i class="fa-solid fa-file-contract"></i> List Contract</li>
                    <?php foreach ($datacont as $key => $value) {
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
                                            <button class="accordion-button rounded bg-green text-white" type="button" data-bs-toggle="collapse" data-bs-target="#contract_value" aria-expanded="true" aria-controls="contract_value">
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
                                            <button class="card-acordion rounded bg-teal text-white" type="button">
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
                                            <button class="card-acordion rounded bg-light-green text-white" type="button">
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
                                            <button class="card-acordion rounded bg-lime text-white" type="button">
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
                                            <div class="rounded d-flex justify-content-center bg-success">
                                                <div class="bg-success text-white d-flex align-items-center">
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
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header text-center bg-teal">
                                        <h5 class="fw-bold text-white">Contract Value / Remaining</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart"></canvas>

                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php $data = $value['dataProvidercav']->getModels(); ?>
                                            <?php foreach ($data as $object) { ?>
                                                <div class="col-md-6">
                                                    <canvas id="chart<?= $object->activity->activity_code ?>"></canvas>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <?php

                        // Convert data to JSON format
                        $budgetDataJson = Json::encode($value['budgetData']);
                        $actualsDataJson = Json::encode($value['actualsData']);

                        // Prepare data for chart
                        // $labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        $data = $value['dataProvidercav']->getModels();
                        // Array of labels
                        $labels = [];
                        // Loop over the array of objects and extract the id property
                        foreach ($data as $object) {
                            $labels[] = $object->activity->activity_name;
                        }

                        $options = [
                            'responsive' => true,
                            'maintainAspectRatio' => false,
                        ];

                        // Create datasets for chart
                        $budgetDataset = [
                            'label' => 'Budget',
                            'data' => $value['budgetData'],
                            'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                            'borderColor' => 'rgba(54, 162, 235, 1)',
                            'borderWidth' => 1,
                        ];
                        $actualsDataset = [
                            'label' => 'Actuals',
                            'data' => $value['actualsData'],
                            'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                            'borderColor' => 'rgba(255, 99, 132, 1)',
                            'borderWidth' => 1,
                        ];
                        $varianceDataset = [
                            'label' => 'Remaining',
                            'data' => array_map(function ($budget, $actuals) {
                                return $budget - $actuals;
                            }, $value['budgetData'], $value['actualsData']),
                            'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                            'borderColor' => 'rgba(255, 206, 86, 1)',
                            'borderWidth' => 1,
                        ];

                        // Convert datasets to JSON format
                        $datasetsJson = Json::encode([$budgetDataset, $actualsDataset, $varianceDataset]);
                        $options_string = json_encode($options);
                        $labels = json_encode($labels);


                        $js = <<<JS
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: $labels,
                            datasets: $datasetsJson,
                        },
                        options: $options_string,
                    });
                    JS;

                        foreach ($data as $key => $object) {
                            $activityCode = $object->activity->activity_code;
                            $activityCode = json_encode($datasasa);

                            $jsx = <<<JS
                        var data1 = {
                            labels: ['Actual', 'Used', 'Remaining'],
                            datasets: [{
                                data: [30, 40, 20],
                                backgroundColor: ['red', 'blue', 'green']
                            }]
                            };

                  

                            var options1 = {
                            // Chart options for chart1
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

                        $this->registerJs(new JsExpression($js));
            ?>
        <?php } ?>
        </div>
    </div>
</div>