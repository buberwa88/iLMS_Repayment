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
                This registration form is for loan refund claimants. Please complete the form below for registration into the iLMS.
            </font>
        </div>
        <div class="panel-body">

    <?= $this->render('_form_refund_register', [
       'model' => $model,
    ]) ?>

</div>
    </div>
</div>