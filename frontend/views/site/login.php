<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use frontend\assets\AppAsset;

$this->title = 'Login';
// $this->params['breadcrumbs'][] = $this->title;
AppAsset::register($this);

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
<style>
    .logincard {

        background-color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }


    .card {

        width: 400px;
        padding: 20px;
        border: none;
    }



    .account {

        font-weight: 500;
        font-size: 17px;
    }

    .contact {

        font-size: 13px;
    }

    .form-control {
        text-indent: 14px;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #4a148c;
        outline: 0;
        box-shadow: none;
    }

    .inputbox {

        margin-bottom: 10px;
        position: relative;
    }

    .inputbox i {

        position: absolute;
        left: 8px;
        top: 12px;
        color: #dadada;
    }


    .form-check-label {

        font-size: 13px;
    }

    .form-check-input {
        width: 14px;
        height: 15px;
        margin-top: 5px;

    }

    .forgot {
        font-size: 14px;
        text-decoration: none;
        color: #4A148C;
    }

    .mail {

        color: #4a148c;
        text-decoration: none;
    }


    .form-check {

        cursor: pointer;
    }

    .btn-primary {
        color: #fff;
        background-color: #4A148C;
        border-color: #4A148C;
    }
</style>
<div class="logincard">

    <div class="card border border-3">
        <div class="text-center intro">
            <img src="https://i.imgur.com/uNiv4bD.png" width="160">
            <span class="d-block account">Don't have account yet?</span>
            <span class="contact">Contact Administrator</span>
        </div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="mt-4 text-center">
            <h4>Log In.</h4>
            <span>Login with your credentials</span>
            <div class="mt-3 inputbox">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder'=> "username"])->label(false) ?>

                <!-- <input type="text" class="form-control" name="" placeholder="Email"> -->
                <i class="fa fa-user"></i>
            </div>
            <div class="inputbox">
                <?= $form->field($model, 'password')->passwordInput(['placeholder'=> "Password"])->label(false) ?>

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
