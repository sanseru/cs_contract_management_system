<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransItem $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Request Order Trans Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="request-order-trans-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'request_order_id',
            'request_order_trans_id',
            'resv_number',
            'ce_year',
            'cost_estimate',
            'ro_number',
            'material_incoming_date',
            'ro_start',
            'ro_end',
            'urgency',
            'qty',
            'id_valve',
            'size',
            'class',
            'equipment_type',
            'sow:ntext',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
            'date_to_status',
            'progress',
        ],
    ]) ?>

</div>
