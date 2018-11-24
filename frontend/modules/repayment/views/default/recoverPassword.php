<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */

$this->title = 'Recover Password';
?>
<div class="employer-change-password">
<div class="panel panel-info">
        <div class="panel-heading">

        </div>
        <div class="panel-body">

    <?= $this->render('_formRecoverPasswordEmployer', [
        'modelUser' => $modelUser,'id'=>$id,
    ]) ?>

</div>
    </div>
</div>
