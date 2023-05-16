<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Item $model */

$this->title = 'Create Item';
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-create">
    <div class="card">

    <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>

        <div class="card-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>