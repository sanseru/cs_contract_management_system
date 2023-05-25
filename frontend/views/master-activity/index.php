<?php

use frontend\models\MasterActivity;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\MasterActivitySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Master Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-activity-index">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        <div class="card-body">

            <p>
                <?= Html::a('Create', ['create'], ['class' => 'btn btn-info']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        'activity_code',
                        'activity_name',
                        'created_at',
                        'updated_at',
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, MasterActivity $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>