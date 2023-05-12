<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ActivityContract $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJs(
    <<<JS
    $(document).ready(function() {
        $('#desc').summernote({
            height: ($(window).height() - 500),
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                }
            }
        });
    });


    function uploadImage(image) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
        url: 'upload-image',
        cache: false,
        contentType: false,
        processData: false,
        data: data,
        type: "post",
        success: function(url) {
            var url = JSON.parse(url);
            console.log(url);
            var image = $('<img>').attr('src', url.url);
            $('#desc').summernote("insertNode", image[0]);
        },
        error: function(data) {
            console.log(data);
        }
    });
}


JS
);

?>

<div class="activity-contract-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'activity')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'activityBy')->textInput(['value' => Yii::$app->user->identity->username, 'maxlength' => true, 'label' => 'Activity By']) ?>
        </div>
    </div>
    <?= $form->field($model, 'description')->textarea(['rows' => 80, 'id' => 'desc']) ?>
    <?= $form->field($model, 'status')->dropDownList([1 => 'Open', 2 => 'On Proggress', 9 => 'Close'], [
        'prompt' => '- Select Status -',         'value' => $model->isNewRecord ? 1 : $model->status
    ]) ?>

    <?= $form->field($model, 'contract_id')->hiddenInput(['value' => $id])->label(false) ?>

    <div class="form-group d-md-flex justify-content-md-end">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>