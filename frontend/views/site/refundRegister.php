<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

?>
<div class="password-reset-beneficiary">

<div class="panel panel-info">
        <div class="panel-heading">
            <font size="4">
                Welcome!
                <br/>
<!--                This registration form is for loan refund claimants. Please complete the form below for registration into the iLMS.-->
                Kindly choose the refund type to get registration into iLMS.
            </font>
        </div>
        <div class="panel-body">
            <div class="col-lg-12" style="text-align: right;"><?php echo Html::a('<i class="glyphicon glyphicon-home"></i>Return Home', ['/application/default/home-page'], ['class' => '','style'=>'margin-top: -10px; margin-bottom: 15px;size:16px']);   ?>
            </div>
    <?= $this->render('_form_refund_category', [
       'model' => $model,
    ]) ?>

</div>
    </div>
</div>