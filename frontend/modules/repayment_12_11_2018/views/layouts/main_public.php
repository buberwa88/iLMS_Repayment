<?php

/**
 * @var $content string
 */
use yii\helpers\Html;

yiister\adminlte\assets\Asset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php $this->head() ?>
        <?= Html::cssFile("@web/css/londinium-theme.css"); ?>
        <?= Html::cssFile("@web/css/styles.css"); ?>
        <?= Html::cssFile("@web/css/custom-general.css"); ?>
        <style type="text/css">
            .content-wrapper,.main-footer{
                margin:auto;
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->beginBody() ?>
        <div class="wrapper">
            <header class="main-header">
                <a href="<?= Yii::$app->getHomeUrl() ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>iLMS</b></span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Login</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Registration</a>
                            <ul class="dropdown-menu dropdown-toggle">
                                <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/signup']) ?>">Applicant Registration</a></li>
                                <li><?= Html::a('Loan Beneficiary Registration', ['/repayment/loan-beneficiary/create']) ?></li>
                                <li><?= Html::a('Employer Registration', ['/repayment/employer/create']) ?></li>
								<li><?= Html::a('Activate Account - Loan Beneficiary', ['/repayment/default/password-reset-beneficiary']) ?></li>
                            </ul>
                        </li>
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/about']) ?>">About</a></li>
                        <li><a href="<?= Yii::$app->urlManager->createUrl(['/site/contact']) ?>">Contact</a></li>
                    </ul>
                    <?php
                    /* \yiister\adminlte\widgets\Menu::widget(
                      [
                      "items" => [
                      ["label" => "Login", "url" => ["/site/login"], "icon" => "login", 'active' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action == 'login')],
                      ["label" => "Registration", "url" => ["#"], "icon" => "login", 'active' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action == 'signup'),
                      "items" => [
                      ["label" => "Applicant Registration", "url" => ["/site/signup"], "icon" => "signup"],
                      ["label" => "Employer Registration", "url" => ["/site/signup"], "icon" => "signup"],
                      ],
                      ],
                      ["label" => "About", "url" => ["/site/about"], "icon" => "about", 'active' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action == 'about')],
                      ["label" => "Contact", "url" => ["/site/contact"], "icon" => "contact", 'active' => (Yii::$app->controller->id == 'site' && Yii::$app->controller->action == 'contact')],
                      ],
                      ]
                      ) */
                    ?>
                </nav>
            </header>
            <div class="content-wrapper">
                <h1 style="text-align:left;">
                    <?= Html::encode(isset($this->params['h1']) ? $this->params['h1'] : $this->title) ?>
                </h1>
                <section class="content"><?= $content ?></section>
            </div>
            <footer class="main-footer">
                <strong>Higher Education Students' Loans Board(HESLB) &copy; <?= date("Y") == "2005" ? "2005" : "2005 - " . date("Y") ?></strong>
                <a class="pull-right hidden-xs" href="http://ucc.co.tz">Powered by UCC</a>
            </footer>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
