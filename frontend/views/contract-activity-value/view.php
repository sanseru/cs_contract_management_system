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
                <?= Html::a('+ Add', ['contract-activity-value-unit-rate/create', 'contract_id' => Yii::$app->request->get('contract_id'), 'act_val_id' => $model->id, 'req_order' => Yii::$app->request->get('req_order')], ['class' => 'btn btn-success']) ?>
            </p>
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProviderCAVUR,
                'filterModel' => $searchModelCAVUR,
                'filterPosition' => false, // this line removes the filter header\
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'activityValue.activity.activity_name',
                    'unitRate.rate_name',
                    [
                        'attribute' => 'myColumn',
                        'label' => 'Scope Of Work',
                        'format' => 'raw',
                        'value' => function ($model) {
                            //Custom logic to get the value
                            $activities = "";
                            $activities = array_map(function ($activity) {
                                return $activity->sow->name_sow;
                            }, $model->contractActivityValueUnitRateSows);
                            $activitys =  implode(', ', $activities);
                            // print_r($activities);die;
                            $skdas = "";
                            foreach ($activities as $key => $value) {
                                $skdas .= "<span class=\"badge bg-warning text-dark\">$value</span> ";
                            }

                            return $skdas;
                        },
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, ContractActivityValueUnitRate $modelCAVUR, $key, $index, $column) use ($model) {
                            if ($action === 'view') {
                                return Url::to(['contract-activity-value-unit-rate/view', 'id' => $modelCAVUR->id, 'req_order' => $model->id, 'contract_id' => Yii::$app->request->get('contract_id'), 'act_val_id' => $model->id, 'req_order' => Yii::$app->request->get('req_order')]);
                            } elseif ($action === 'update') {
                                return Url::to(['contract-activity-value-unit-rate/update', 'id' => $modelCAVUR->id, 'req_order' => $model->id, 'contract_id' => Yii::$app->request->get('contract_id'), 'act_val_id' => $model->id, 'req_order' => Yii::$app->request->get('req_order')]);
                            } elseif ($action === 'delete') {
                                return Url::to(['contract-activity-value-unit-rate/delete', 'id' => $modelCAVUR->id]);
                            }
                        }
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>