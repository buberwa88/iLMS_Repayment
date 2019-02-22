<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
$this->title = 'Step 1: Form 4 Education';
?>
<div class="loan-repayment-update">
<div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form_f4educationpreview', [
        'model' => $model,
    ]) ?>
</div>
</div>
</div>
