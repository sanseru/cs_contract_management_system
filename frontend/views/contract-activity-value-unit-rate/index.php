<?php

use frontend\models\ContractActivityValueUnitRate;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValueUnitRateSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Contract Activity Value Unit Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-activity-value-unit-rate-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Contract Activity Value Unit Rate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'contract_id',
            'activity_value_id',
            'unit_rate_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ContractActivityValueUnitRate $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
