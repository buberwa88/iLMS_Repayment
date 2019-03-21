<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'control_number')->textInput(['value'=>$paymentRefNo,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'totalAmount')->label("Pay Amount")->textInput(['value'=>  number_format($amount,2),'readOnly'=>'readOnly']) ?>
    <?php ActiveForm::end(); ?>

</div>
