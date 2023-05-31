<?php

use yii\bootstrap5\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
    <style>
        * {
            transition: all 0.6s;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Lato', sans-serif;
            color: #888;
            margin: 0;
        }

        #main {
            display: table;
            width: 100%;
            height: 100vh;
            text-align: center;
        }

        .fof {
            display: table-cell;
            vertical-align: middle;
        }

        .fof h1 {
            font-size: 50px;
            display: inline-block;
            padding-right: 12px;
            animation: type .5s alternate infinite;
        }

        @keyframes type {
            from {
                box-shadow: inset -3px 0px 0px #888;
            }

            to {
                box-shadow: inset -3px 0px 0px transparent;
            }
        }
    </style>
</head>
<?php $this->beginBody() ?>

<body>
    <div id="main">
        <div class="fof">
            <h1>Error Page 404</h1>
            <?= nl2br(Html::encode($message)) ?>
            <p>
                The above error occurred while the Web server was processing your request.
            </p>
            <p>
                Please contact us if you think this is a server error. Thank you.
            </p>
            <div class="mt-5">
                <button class="btn btn-lg btn-outline-info" onclick="goBack()">Go Back</button>
            </div>
        </div>

    </div>
</body>
<?php $this->endBody() ?>
<script>
    function goBack() {
        window.history.back();
    }
</script>

</html>
<?php $this->endPage();
