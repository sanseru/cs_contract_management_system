<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\RequestOrderTrans $model */

$this->title = 'Create Request Order Trans';
$this->params['breadcrumbs'][] = ['label' => 'Request Order Trans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-trans-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'client_id' =>$client_id,
    ]) ?>

</div>
