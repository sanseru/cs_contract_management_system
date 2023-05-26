<?php

use frontend\models\Costing;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\CostingSerach $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Costings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="costing-index">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        <div class="card-body">
            <p>
                <?= Html::a('Create Costing', ['create'], ['class' => 'btn btn-info']) ?>
            </p>
            <div class="table-responsive">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); 
                ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Client Name',
                            'attribute' => 'clientName',
                            'value' => 'client.name'
                        ],
                        [
                            'label' => 'Contract Number',
                            'attribute' => 'contractNumber',
                            'value' => 'clientContract.contract_number',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center'],
                        ],
                        [
                            'label' => 'Rate Name',
                            'attribute' => 'rateName',
                            'value' => 'unitRate.rate_name'
                        ],
                        [
                            'label' => 'Item Detail',
                            'attribute' => 'itemDetail',
                            'contentOptions' => ['class' => 'fw-lighter', 'style'=> 'font-size:10px'],
                            'format' => 'raw', // Set the format to 'raw'
                            'value' => function ($model) {   

                                return 
                                'Activity : '.$model->item->masterActivityCode->activity_name.'<br>'
                                .'Type name : '.$model->item->itemType->type_name.'<br>'
                                .'Size : '.$model->item->size.'<br>'
                                .'Class : '.$model->item->class;
                            }
                        ],
                        [
                            'attribute' => 'price',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asCurrency($model->price, 'IDR');
                            }
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, Costing $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
</div>