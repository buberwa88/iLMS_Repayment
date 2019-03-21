<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'control_number')->textInput(['value'=>$model->control_number,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'amount')->label("Pay Amount")->textInput(['value'=>number_format($model->amount,2),'readOnly'=>'readOnly']) ?>
    <?php ActiveForm::end(); ?>

</div>
