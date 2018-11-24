<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */
$this->title = 'Add new amount for: '.$model->amount;
?>
<div class="employer-penalty-payment-update">
<div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_formAdjustAmount', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
