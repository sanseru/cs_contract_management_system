<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Client $model */

$this->title = 'Create Client';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-create">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>