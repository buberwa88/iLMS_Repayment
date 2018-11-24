<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use kartik\sidenav\SideNav;
use yii\helpers\Url;
use app\models\Users;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerJsFile(
    '@web/js/pace.min.js'
);

$this->registerCssFile(
    '@web/css/pace_loading_bar.css'
);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?php
        if (Yii::$app->user->isGuest) {
            echo "<script>";
            echo "window.opener.location.reload();";
            echo "</script>";
        }
        ?>
    </head>
    <body style="margin-top: -40px; margin-left: 10px; margin-right: 10px">

        <?php $this->beginBody() ?>
        <!DOCTYPE html>

    <link href="css/dashboard.css" rel="stylesheet">
    <script src="js/ie-emulation-modes-warning.js"></script>

    <?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
    <?php $this->endPage() ?>
