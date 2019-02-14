<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
?>
<div class="password-reset-beneficiary">

    <div class="panel panel-info">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <?php
            echo $this->render('form_submit_token', [
                'model' => $model,
            ]);
            ?> 
        </div>
    </div>
</div>