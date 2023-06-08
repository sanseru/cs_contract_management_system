<?php

use frontend\models\MasterActivity;
use frontend\models\MasterScopeOfWork;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValue $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJs(
    <<<JS
        $('#sow_id').select2();

        const addRowButton = document.querySelector('.add-row');
            const tableBody = document.querySelector('#table-body');

            addRowButton.addEventListener('click', () => {
                const newRow = `
                            <tr>
                            <td style="width:60%;"><select class="form-control select2" name="sow[]" /></td>
                            <td style="width:20%;">
                            <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="kpisow[]" />
                                    <span class="input-group-text text-center" id="basic-addon2">%</span>
                                </div>
                            </td>
                            <td style="width:10%;"><button type="button" class="btn btn-danger delete-row">Delete</button></td>
                            </tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                $('.select2').select2({
                placeholder: 'Pilih Produk',
                allowClear: true,
                ajax: {
                    url: '/contract-activity-value/get-data',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, item) {
                            results.push({
                                id: item.id,
                                text: item.name_sow
                            });
                        });
                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });

            });

            tableBody.addEventListener('click', (event) => {
                if (event.target.classList.contains('delete-row')) {
                    event.target.closest('tr').remove();
                }
            });

            $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Pilih Produk',
                allowClear: true,
                ajax: {
                    url: '/contract-activity-value/get-data',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, item) {
                            results.push({
                                id: item.id,
                                text: item.name_sow
                            });
                        });
                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });
        });

    JS
);




if (!$model->isNewRecord) {
    $forms = "";
    foreach ($model->contractActivityValueSows as $key => $sowId) {
        $forms .= '<tr>
        <td style="width:60%;">
            <select class="form-control select2" name="sow[]">
            <option value="' . $sowId->sow_id . '" selected>' . $sowId->sow->name_sow . '</option>
            </select>
        </td>
        <td style="width:20%;">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="kpisow[]" value="' . $sowId->sow_kpi . '"/>
                <span class="input-group-text text-center" id="basic-addon2">%</span>
            </div>
        </td>
        <td style="width:10%;"><button type="button" class="btn btn-danger delete-row" onclick="$(this).closest(\'tr\').remove();">Delete</button></td>
    </tr>';
    }



    $this->registerJs(<<<JS
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Pilih Produk',
                allowClear: true,
                ajax: {
                    url: '/contract-activity-value/get-data',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        var results = [];
                        $.each(data, function(index, item) {
                            results.push({
                                id: item.id,
                                text: item.name_sow
                            });
                        });
                        return {
                            results: results
                        };
                    },
                    cache: true
                }
            });

            

        });
JS);
}


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


<div class="contract-activity-value-form">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $contract_id])->label(false) ?>

                <?= $form->field($model, 'activity_id')->dropDownList(
                    ArrayHelper::map(MasterActivity::find()->all(), 'id', 'activity_name'),
                    [
                        'prompt' => 'Select an option...', 'id' => 'activity_id'
                    ]
                )->label('Activity Name') ?>

                <?= $form->field($model, 'value')->textInput(['maxlength' => true])->widget(\yii\widgets\MaskedInput::class, [
                    'clientOptions' => [
                        'alias' => 'numeric',
                        'groupSeparator' => ',',
                        'autoGroup' => true,
                        'digits' => 0,
                        'prefix' => 'IDR ',
                        'removeMaskOnSubmit' => true,
                    ],
                    'options' => [
                        'autocomplete' => 'off',
                    ],
                ]); ?>

                <?php
                //  $form->field($model, 'sow')->dropDownList(
                //     ArrayHelper::map(MasterScopeOfWork::find()->all(), 'id', 'name_sow'),
                //     [
                //         'multiple' => 'multiple', 'id' => 'sow_id'
                //     ]
                // )->label('Scope Of Work') 
                ?>

                <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $contract_id])->label(false) ?>

                <table class="table ">
                    <thead>
                        <tr>
                            <th>Scope Of Work</th>
                            <th style="text-align:center;">KPI %</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="table-body">

                        <?php
                        if (!$model->isNewRecord) {
                            echo $forms;
                        } ?>
                        <tr>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary add-row"> + Add</button>
                <div class="d-grid gap-2 form-group mt-3 text-center">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>