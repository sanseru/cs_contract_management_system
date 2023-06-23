<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Contrack Management System';
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 bg-cs1 text-white hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-lock-open fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ORDER OPEN</div>
                    <div class="number text-white"><?= $requestOpen ?></div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 text-white bg-cs2 hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-list fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ACTIVITY ORDER OPEN</div>
                    <div class="number text-white"><?php // $activityOpen ?></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 text-white bg-cs3 hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-list-check fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ACTIVITY ON PROCESS</div>
                    <div class="number text-white"><?php // $activityProcess ?></div>
                </div>
            </div>
        </div> -->
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 text-white bg-cs4 hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-lock fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ORDER CLOSED</div>
                    <div class="number text-white"><?= $requestClosed ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-1 mb-2 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Congratulations!</h1>
            <p class="fs-5 fw-light">Welcome To Contract Management System</p>
            <!-- <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
        </div>
    </div>

    <div class="body-content">

        <div class="row">
            <?= Html::img('@web/images/home.svg', ['alt' => 'Home', 'width' => 150, 'height' => 300]); ?>
        </div>

    </div>
</div>



