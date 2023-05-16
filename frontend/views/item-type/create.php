<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ItemType $model */

$this->title = 'Create Item Type';
$this->params['breadcrumbs'][] = ['label' => 'Item Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
