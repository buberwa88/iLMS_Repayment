<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput(['value'=>$amount,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'totalEmployees')->textInput(['value'=>$totalEmployees,'readOnly'=>'readOnly']) ?>

    <div class="form-group">
        <?= Html::a('Click here to confirm for payment', ['confirm-payment','loan_repayment_id'=>$loan_repayment_id], ['class' => 'btn btn-success']) ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a('Request Adjustments', ['request-payment-adjustment','loan_repayment_id'=>$loan_repayment_id], ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
