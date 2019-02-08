<?php

use yii\helpers\Html;
use  yii\web\Session;
$session = Yii::$app->session;
$session->set('refund_claimant_id', $id);
$refundApplicationID=\frontend\modules\repayment\models\RefundApplication::getRefundApplicationDetails($id)->refund_application_id;
$session->set('refund_application_id', $refundApplicationID);

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

?>
<div class="password-reset-beneficiary">

<div class="panel panel-info">
        <div class="panel-heading">
            <font size="4">
                Please confirm refund application number by putting code sent into your mobile phone or email address.
            </font>
        </div>
        <div class="panel-body">

    <?= $this->render('_form_confirmapplicationcode', [
       'model' => $model,'id'=>$id,
    ]) ?>

</div>
    </div>
</div>