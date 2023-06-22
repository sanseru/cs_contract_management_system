<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Contrack Management System';
?>
<div class="site-index card mt-4">
    <div class="card-header text-center bg-info-subtle">
        <h3 class="fw-bold"><?= Yii::$app->user->identity->client->name; ?></h3>
    </div>
    <div class="body-content card-body">
    <input type="text" class="form-control" id="searchContract" placeholder="Search Contract Number">
        <div class="row mt-2">
            <div class="accordion" id="accordionUtama">
                <?php foreach ($result as $key => $value) { ?>
                    <div class="accordion-item utama-acor">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?= $key != 0 ? 'collapsed' : '' ?>" type=" button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapse<?= $key ?>">
                            <span><i class="fa-solid fa-file-contract"></i>  Contract <?= $value['contract']->contract_number  ?></span> 
                            </button>
                        </h2>
                        <div id="collapse<?= $key ?>" class="accordion-collapse collapse <?= $key == 0 ? 'show' : '' ?>" data-bs-parent="#accordionUtama">
                            <div class="accordion-body">
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
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <script>
                    // Tangkap elemen input pencarian
                    var searchInput = document.getElementById('searchContract');

                    // Tangkap semua elemen accordion item
                    var accordionItems = document.getElementsByClassName('utama-acor');

                   

                    // Tambahkan event listener pada input pencarian
                    searchInput.addEventListener('input', function() {
                        var searchValue = this.value.toLowerCase();

                        // Loop melalui setiap accordion item
                        for (var i = 0; i < accordionItems.length; i++) {
                            var accordionHeader = accordionItems[i].querySelector('.accordion-header');
                            var contractNumber = accordionHeader.textContent.toLowerCase();
                            // console.log(accordionHeader);
                            // Periksa apakah nomor kontrak mengandung teks pencarian
                            if (contractNumber.includes(searchValue)) {
                                accordionItems[i].style.display = 'block';
                            } else {
                                accordionItems[i].style.display = 'none';
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>