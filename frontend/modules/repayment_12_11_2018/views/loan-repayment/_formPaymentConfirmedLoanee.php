<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'repayment_reference_number')->textInput(['value'=>$paymentRefNo,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'amount')->textInput(['value'=>$amount,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'totalEmployees')->textInput(['value'=>$totalEmployees,'readOnly'=>'readOnly']) ?>
    <?php ActiveForm::end(); ?>

</div>
