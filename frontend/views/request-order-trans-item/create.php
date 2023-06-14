<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTransItem $model */

$this->title = 'Create Request Order Trans Item';
$this->params['breadcrumbs'][] = ['label' => 'Request Order Trans Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-trans-item-create">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>