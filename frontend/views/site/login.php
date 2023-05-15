<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use frontend\assets\AppAsset;
use yii\web\View;

$this->title = 'Login';
// $this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);


$this->registerCssFile("@web/css/login.css", [
    'depends' => [\yii\bootstrap5\BootstrapAsset::class],
], 'login');

?>
<?php $this->beginPage() ?>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<div class="logincard">
    <div class="card border border-3">
        <div class="text-center intro">
            <span class="d-block account mb-4">Contract Management System</span>
            <?= Html::img('@web/images/login.svg', ['alt' => 'Login Image', 'width' => 160]); ?>
            <!-- <img src="https://i.imgur.com/uNiv4bD.png" width="160"> -->
            <span class="d-block account">Don't have account yet?</span>
            <span class="contact">Contact Administrator</span>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="mt-4 text-center">
            <h4>Log In.</h4>
            <span>Login with your credentials</span>
            <div class="mt-3 inputbox">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => "username"])->label(false) ?>

                <!-- <input type="text" class="form-control" name="" placeholder="Email"> -->
                <i class="fa fa-user"></i>
            </div>
            <div class="inputbox">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => "Password"])->label(false) ?>

                <!-- <input type="text" class="form-control" name="" placeholder="Password"> -->
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <!-- <div class="d-flex justify-content-between">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Keep me Logged in
                </label>
            </div>
            <div>
                <a href="#" class="forgot">Forgot Password?</a>
            </div>
        </div> -->
        <div class="mt-2">
            <button class="btn btn-primary btn-block">Log In</button>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php $this->endBody() ?>

<?php $this->endPage();
