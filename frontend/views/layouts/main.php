<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Management Contract System adalah sebuah aplikasi manajemen kontrak yang dirancang untuk membantu perusahaan dalam mengatur dan melacak kontrak dari klien mereka. Dengan menggunakan aplikasi ini, perusahaan dapat dengan mudah mengelola kontrak dari awal hingga akhir, termasuk pengaturan kontrak, penandatanganan, dan pelacakan status kontrak.">
    <meta name="author" content="PT. Control System">
    <meta name="keywords" content="contract management system, ptcs, controlsystem">

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <header>
        <?php
        NavBar::begin([
            'brandLabel' => '<i class="fa-solid fa-network-wired"></i> ' . Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-navbarblueindigo fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => '<i class="fas fa-home"></i> Home', 'url' => ['/site/index']],
            ['label' => '<i class="fa-solid fa-receipt"></i> Order', 'url' => ['/request-order/index']],
            [
                'label' => '<i class="fa-solid fa-cube"></i> Configuration',
                'items' => [
                    ['label' => '<i class="fa-solid fa-address-book fa-sm"></i> Client', 'url' => ['/client/index']],
                    ['label' => '<i class="fa-solid fa-list-check"></i> Activity', 'url' => ['/master-activity/index']],
                    ['label' => '<i class="fa-solid fa-barcode fa-sm"></i> Item', 'url' => ['/item/index']],
                    ['label' => '<i class="fa-solid fa-equals fa-sm"></i> Unit Rate', 'url' => ['/unit-rate/index']],
                    ['label' => '<i class="fa-solid fa-money-check-dollar fa-sm"></i> Costing', 'url' => ['/costing/index']],



                ],
            ],
        ];

        $menuItemsClient = [
            ['label' => '<i class="fas fa-home"></i> Home', 'url' => ['/site/index']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        }else if (Yii::$app->user->identity->user_type_id == 3){
            echo Nav::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
                'items' => $menuItemsClient,
            ]);
        }else{
            echo Nav::widget([
                'encodeLabels' => false,
                'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
                'items' => $menuItems,
            ]);
        }



        if (Yii::$app->user->isGuest) {
            echo Html::tag('div', Html::a('Login', ['/site/login'], ['class' => ['btn bg-beigebtn login text-decoration-none']]), ['class' => ['d-flex']]);
        } else {
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(
                    '<i class="fa-solid fa-arrow-right-from-bracket fa-sm"></i> Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout text-decoration-none text-white']
                )
                . Html::endForm();
        }
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'options' => [
                    'class' => '', // add class to the <ol> tag
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-end">Powered By PDI</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
