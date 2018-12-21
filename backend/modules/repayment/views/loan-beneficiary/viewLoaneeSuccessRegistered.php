<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
$this->title = 'Loan Beneficiaries Registration';
?>
<div class="employer-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?php if ($loaneeStatus == '1') { ?>
                <br/>
                <font size="4">  
                Your information have been received to HESLB, You will get notification though EMAIL after your account being successful verified by HESLB, thank you!.
                </font>
                <br/>
            <?php } else if ($loaneeStatus == '2') { ?>
                <font size="4">
                Congratulations!
                <br/>
                Your information have been received to HESLB, Kindly open the notification sent to your EMAIL so that you can access your iLMS account, thank you!.
                </font>
                <br/>
                <br/>
                <?php
                echo $activateNotification;
            }
            ?>
        </div>
    </div>
</div>
