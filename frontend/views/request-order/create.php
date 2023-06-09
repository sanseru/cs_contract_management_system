<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Contract $model */

$this->title = 'Create Request order';
$this->params['breadcrumbs'][] = ['label' => 'Request Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-create">
    <div class="card">
        <h5 class="card-header bg-1D267D text-white"><?= Html::encode($this->title) ?></h5>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
</div>