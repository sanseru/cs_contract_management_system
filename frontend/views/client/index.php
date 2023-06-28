<?php

use frontend\models\Client;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/** @var yii\web\View $this */
/** @var frontend\models\ClientSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">
    <div class="card">
        <h5 class="card-header bg-formbarblue text-white"><?= Html::encode($this->title) ?></h5>
        <div class="card-body">

            <p>
                <?= Html::a('Create', ['create'], ['class' => 'btn bg-btnblue text-white']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        'address:ntext',
                        'phone_number',
                        'email:email',
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, Client $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                        ],
                    ],
                ]); ?>


            </div>
        </div>

    </div>
</div>