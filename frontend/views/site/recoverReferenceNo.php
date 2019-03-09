<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
$this->title = 'Recover Mys Refund Reference No';
?>
<div class="password-reset-beneficiary">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php
            if (Yii::$app->session->hasFlash('success')) {
                ?>
                <p class="success"> <?php echo Yii::$app->session->getFlash('success'); ?></p>
                <?php
            }
            if (Yii::$app->session->hasFlash('failure')) {
                ?>
                <p class="fail"> <?php echo Yii::$app->session->getFlash('failure'); ?></p>
                <?php
            }
            ?>
            <?php
            echo $this->render('_form_recover_reference_no', [
                'model' => $model,
            ]);
            ?>
        </div>
    </div>
</div>