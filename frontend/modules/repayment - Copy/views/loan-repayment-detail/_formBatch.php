<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'bill_number')->textInput(['value'=>$bill_number,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'control_number')->textInput(['value'=>$paymentRefNo,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'totalAmount')->textInput(['value'=>  number_format($amount,2),'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'payment_status')->textInput(['value'=>$payment_status,'readOnly'=>'readOnly']) ?>
    <?php ActiveForm::end(); ?>

</div>
