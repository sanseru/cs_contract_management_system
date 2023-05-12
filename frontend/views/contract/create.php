<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Contract $model */

$this->title = 'Create Contract';
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contract-create">
    <div class="card">
        <h5 class="card-header bg-primary text-white"><?= Html::encode($this->title) ?></h5>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
</div>