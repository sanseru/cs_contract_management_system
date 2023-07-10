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
// AppAsset::register($this);


$this->registerCssFile("@web/css/clont.css");
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css', ['integrity' => 'YOUR_INTEGRITY_VALUE', 'crossorigin' => 'anonymous']);

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
<!-- <div class="logincard"> -->
<div class="container-fluid">
    <div class="row content-frame ml-0">
        <div class="col-md-3 p-0 left-col">
            <div class="image-container">
                <?= Html::img('@web/images/ptcs.png', ['alt' => 'Img PTCS', 'class' => 'img-ptcs']); ?>
            </div>
            <div class="row">
                <div class="col-12 pl-7 pr-7 form-horizontal form-material">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                    <h1 class="text-login">Login</h1>
                    <p class="text-signin">Sign In to your account</p>
                    <div class="input-group mb-3 field-loginform-username required">
                        <span class="input-group-addon bg-white border-0"><i class="fa fa-user pt-1"></i></span>
                        <input type="text" class="form-control border-0" name="LoginForm[username]" autofocus="true" placeholder="Username" value="">
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-addon bg-white border-0"><i class="fa fa-lock pt-1"></i></span>
                        <input type="password" class="form-control border-0" name="LoginForm[password]" id="LoginForm[password]" placeholder="Password">
                    </div>
                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-login btn-block">Login</button>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-md-9  p-0">
            <!-- content-frame-kanan -->
            <?= Html::img('@web/images/valve.jpg', ['alt' => 'Img PTCS', 'width' => '100%', 'height' => '400px']); ?>
            <div class="content-frame-kanan-text">
                <span class="font-weight-semibold text-ptcs">PT. Control Sytems Arena Para Nusa</span>
                <p class="font-weight-bold text-title"></p>
                <span class="font-weight-bold text-subtitle">Contract Management</span>
                <p class="text-description">
                    Welcome to PT. Control Systems Contract management Software. Our software provides a comprehensive solution that empowers contract managers and their customers to efficiently manage and monitor contracts. With our intuitive interface and advanced features, you can easily navigate through the contract lifecycle, ensuring seamless collaboration and effective oversight. Please enter your credentials to access the full suite of contract management tools and unlock the potential of enhanced contract administration.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    html,
    body {
        height: 100%;
    }

    .container-fluid {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0;
        /* justify-content: center; */
    }

    .content-frame {
        height: 100%;
        width: 100%;
        display: flex;
        padding: 0;
        margin-right: 0;
    }

    .img-ptcs {
        width: 10rem;
        margin-bottom: 8rem;
        margin-top: 1rem;
        margin-left: 1.2rem;
    }

    .content-test {
        height: 100% !important;
    }

    .content-frame-kanan {
        background-image: url("../images/valve.jpg");
        background-repeat: no-repeat;
        background-position-y: -8rem;
        background-size: cover;
        /* Ensures the background image covers the entire container */
        padding: 0;
        height: 400px;

    }


    .content-frame-kanan-text {
        margin-top: 0rem;
        background-color: white;
        padding: 1rem;
    }

    .text-ptcs {
        font-size: 1.7rem;
        color: #155584;
    }

    .text-title {
        font-size: 2.5rem;
        padding-top: 0.2rem;
        margin-bottom: 0;
        color: #155584;
    }

    .text-subtitle {
        font-size: 2rem;
        padding-top: 0;
        color: #155584;
    }

    .text-description {
        padding-top: 1rem;
        text-align: justify;
        font-size: 1.1rem;
    }

    .left-col {
        background-color: #1a6aa5;
    }

    .text-login {
        color: #F0F0F0;
        font-weight: 600;
    }

    .text-signin {
        color: #BDCDD6;
    }

    .text-forgot-password {
        color: #B2B2B2;
    }

    .btn-login {
        background-color: #a3c3db;
    }

    .inner-addon {
        position: relative;
    }

    .inner-addon .fa-solid {
        position: absolute;
        padding: 10px;
        pointer-events: none;
    }

    .left-addon .fa-solid {
        left: 0px;
    }

    .left-addon input {
        padding-left: 30px;
    }

    .image-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<?php $this->endBody() ?>

<?php $this->endPage();
