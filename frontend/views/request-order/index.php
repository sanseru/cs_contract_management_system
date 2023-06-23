<?php

use frontend\models\RequestOrder;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\ContractSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-index">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        <div class="card-body">

            <p>
                <?= Html::a(Html::tag('i', '', ['class' => 'fa-solid fa-plus']) . ' Create Order', ['create'], ['class' => 'btn bg-cs1 text-white btn-sm ml-5']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => ['class' => 'table table-striped table-bordered text-sm text-center font-monospace table-responsive'],
                'filterRowOptions' => ['class' => 'input-group-sm'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'ro_number',
                    [
                        'label' => 'Client Name',
                        'attribute' => 'clientName',
                        'value' => 'client.name'
                    ],
                    'so_number',
                    'contract_type',
                    [
                        'attribute' => 'requestOrderActivities',
                        'value' => function ($model) {
                            $activities = array_map(function ($activity) {
                                return $activity->activityCode->activity_name;
                            }, $model->requestOrderActivities);
                            return implode(', ', $activities);
                        },
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {

                            $badgeClass = 'bg-secondary';
                            switch ($model->status) {
                                case '1':
                                    $badgeClass = 'bg-success';
                                    $status = 'RO Received';
                                    break;
                                case '2':
                                    $badgeClass = 'bg-primary';
                                    $status = 'Work In Progress';
                                    break;
                                case '3':
                                    $badgeClass = 'bg-info';
                                    $status = 'Work Completed';
                                    break;
                                case '4':
                                    $badgeClass = 'bg-secondary';
                                    $status = 'Invoiced';
                                    break;
                                case '9':
                                    $badgeClass = 'bg-warning text-dark';
                                    $status = 'Paid';
                                    break;
                                case 'Cancelled':
                                    $badgeClass = 'bg-danger';
                                    $status = 'Cancelled';
                                    break;
                                default:
                                    $badgeClass = 'bg-secondary';
                                    $status = 'Unknown';
                                    break;
                            }
                            

                            return "<span class=\"badge " . $badgeClass . "\" style=\"padding: 5px 5px;\">" . $status . "</span>";
                        }
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, RequestOrder $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

        </div>
    </div>
</div>