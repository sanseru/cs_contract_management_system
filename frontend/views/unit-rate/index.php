<?php

use frontend\models\UnitRate;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\UnitRateSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Unit Rates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-rate-index">

    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        <div class="card-body">
            <p>
                <?= Html::a('Add Unit Rate', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'rate_name',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, UnitRate $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>


        </div>
    </div>
</div>
