<?php

use frontend\models\RequestOrderTrans;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Request Order Trans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-trans-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Request Order Trans', ['create'], ['class' => 'btn btn-success']) ?>
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
