<?php

use frontend\models\RequestOrderTransItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransItemSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Request Order Trans Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-trans-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Request Order Trans Item', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'request_order_id',
            'request_order_trans_id',
            'resv_number',
            'ce_year',
            //'cost_estimate',
            //'ro_number',
            //'material_incoming_date',
            //'ro_start',
            //'ro_end',
            //'urgency',
            //'qty',
            //'id_valve',
            //'size',
            //'class',
            //'equipment_type',
            //'sow:ntext',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            //'date_to_status',
            //'progress',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, RequestOrderTransItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
