<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\ClientContract;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use yii\jui\DatePicker;

/** @var yii\web\View $this */
/** @var frontend\models\Client $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">
    <div class="card">
        <h5 class="card-header bg-secondary text-white">#<?= Html::encode($this->title) ?></h5>
        <div class="card-body">
            <p>
                <?php // Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) 
                ?>
                <?php // Html::a('Delete', ['delete', 'id' => $model->id], [
                // 'class' => 'btn btn-danger',
                // 'data' => [
                //     'confirm' => 'Are you sure you want to delete this item?',
                //     'method' => 'post',
                // ],
                // ]) 
                ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'address:ntext',
                    'phone_number',
                    'email:email',
                    'created_at',
                    'updated_at',
                ],
            ]) ?>

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">#Contract</h5>
            <?= Html::button('Add Contract', ['class' => 'btn btn-info btn-modal', 'data-target' => '#myModal', 'data-toggle' => 'modal']) ?>

            <!-- <a href="<?= Url::toRoute(['activity-contract/create', 'id' => $model->id]); ?>"><button class="btn btn-sm btn-primary">Add Contract</button></a> -->
        </div>
        <div class="card-body">
            <?php Pjax::begin([
                'id' => 'my-pjax',
            ]); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProviderClientContract,
                'filterModel' => $searchModelClientContract,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'contract_number',
                    [
                        'label' => 'Client Name',
                        'attribute' => 'clientName',
                        'value' => 'client.name'
                    ],
                    'start_date',
                    'end_date',
                    //'created_by',
                    //'created_at',
                    //'updated_by',
                    //'updated_at',
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{view} {update} {delete}', // Show only Update and Delete buttons
                        'urlCreator' => function ($action, ClientContract $modelClientContract, $key, $index, $column) {
                            if ($action === 'view') {
                                return Url::to(['client-contract/view', 'id' => $modelClientContract->id]);
                            } elseif ($action === 'update') {
                                return Url::to(['client-contract/update', 'id' => $modelClientContract->id]);
                            } elseif ($action === 'delete') {
                                return Url::to(['client-contract/delete', 'id' => $modelClientContract->id, 'client' => $modelClientContract->client_id]);
                            }
                            // return Url::toRoute([$action, 'id' => $model->id]);
                        },
                        'contentOptions' => ['style' => 'width:100px']
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>

<?php
Modal::begin([
    'title' => '<h5>Add Contract</h5>',
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'myModal',
    'size' => 'modal-sm', // ukuran modal: large, medium, small, fullscreen
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => TRUE]
]);


?>
<?php $form = ActiveForm::begin(['id' => 'my-form']); ?>
<?= $form->field($modelClientContract, 'client_id')->hiddenInput(['value' => $model->id])->label(false) ?>

<div class="row">
    <?= $form->field($modelClientContract, 'contract_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelClientContract, 'start_date')->widget(DatePicker::className(), [
        'dateFormat' => 'dd-MM-yyyy', // format tanggal yang digunakan
        'options' => ['class' => 'form-control'], // opsi tambahan untuk input field
    ]) ?>

    <?= $form->field($modelClientContract, 'end_date')->widget(DatePicker::className(), [
        'dateFormat' => 'dd-MM-yyyy', // format tanggal yang digunakan
        'options' => ['class' => 'form-control'], // opsi tambahan untuk input field
    ]) ?>

</div>


<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>


<?php
Modal::end();
?>

<?php
$this->registerJs(
    <<<JS
        $(document).on('click', '.btn-modal', function (e) {
            $('#myModal').modal('show');
        });

        $(document).on('submit', '#my-form', function(e) {
            e.preventDefault();
            console.log($(this).serialize());
            $.ajax({
                type: 'post',
                url: '/client-contract/create',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.status == 'success' ){
                        $('#my-form')[0].reset();
                        $('#myModal').modal('hide');
                        $.pjax.reload({container:'#my-pjax'});
                        alert('Berhasil Di Tambahkan');
                    }else{
                        alert('Failed Save To Server');
                    }
                    // do something with the response data
                },
                error: function() {
                    alert('An error occurred while submitting the form.');
                }
            });
        });
    JS
);
?>