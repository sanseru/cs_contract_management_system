<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;

$this->title = 'Contrack Management System';
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 bg-teal text-white hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-lock-open fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ORDER OPEN</div>
                    <div class="number text-white">7</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 text-white bg-green hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-list fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ACTIVITY ORDER OPEN</div>
                    <div class="number text-white">4</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 text-white bg-light-green hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-list-check fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ACTIVITY ON PROCESS</div>
                    <div class="number text-white">3</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box-4 text-white bg-lime hover-expand-effect">
                <div class="icon">
                    <i class="fa-solid fa-lock fa-2xl"></i>
                </div>
                <div class="content">
                    <div class="text text-white">ORDER CLOSED</div>
                    <div class="number text-white">5</div>
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

            <!-- <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div> -->
        </div>

    </div>
</div>