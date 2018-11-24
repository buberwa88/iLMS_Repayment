<?php

use yii\helpers\Html;

$this->title = "Home | iLMS";
?>
<style type="text/css">
    .btn.btn-app{
        min-width:250px;
        min-height:180px;
    }
</style>
<div class="box box-info">
    <div class="box-body">
        <div class="row-fluid">
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/about']) ?>" class="btn btn-app">
                <i><?php echo Html::img('@web/image/jobcardassign.png') ?></i>
                <div>About</div>
            </a>
            <a href="<?= Yii::$app->urlManager->createUrl(['/site/contact']) ?>" class="btn btn-app">
                <i><?php echo Html::img('@web/image/jobcardassign.png') ?></i>
                <div>Contact</div>
            </a>
            <a href="<?= Yii::$app->urlManager->createUrl(['site/index', 'id' => 1]) ?>" class="btn btn-app">
                <i><?php echo Html::img('@web/image/Report.png') ?></i>
                <div>Reports</div>
            </a>
        </div>
    </div>
</div>  
