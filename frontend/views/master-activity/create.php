<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\MasterActivity $model */

$this->title = 'Create Master Activity';
$this->params['breadcrumbs'][] = ['label' => 'Master Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
