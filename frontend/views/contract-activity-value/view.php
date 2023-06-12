<?php

use frontend\models\ContractActivityValueUnitRate;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\ContractActivityValue $model */

$this->title = $model->contract->contract_number . " - " . $model->activity->activity_name;
$this->params['breadcrumbs'][] = ['label' => 'Client', 'url' => ['client/index']];
$this->params['breadcrumbs'][] = ['label' => 'Client Contract', 'url' => ['client-contract/view', 'id' => Yii::$app->request->get('contract_id'), 'req_order' => Yii::$app->request->get('req_order'), 'kpi' => 1]];
$this->params['breadcrumbs'][] = "Contract Activity KPI " . $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contract-activity-value-view">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        <div class="card-body">
            <!-- <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p> -->

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'contract.contract_number',
                    'activity.activity_name',
                    'value',
                ],
            ]) ?>

        </div>
    </div>

    <div class="card mt-3">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        <div class="card-body">
            <p>
                <?= Html::a('Create Contract Activity Value Unit Rate', ['contract-activity-value-unit-rate/create', 'contract_id'=> Yii::$app->request->get('contract_id'), 'act_val_id'=>$model->id], ['class' => 'btn btn-success']) ?>
            </p>
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProviderCAVUR,
                'filterModel' => $searchModelCAVUR,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
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
    </div>

</div>