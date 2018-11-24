<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-summary-form">

    <?php $form = ActiveForm::begin(['action' => ['loan-repayment/payment-adjustment-processing-loanee'],'options' => ['method' => 'post']]); ?>
    <?= $form->field($model, 'applicant_id')->label(false)->hiddenInput(['value'=>$applicantID,'readOnly'=>'readOnly']) ?>
<?= $form->field($model, 'loan_repayment_id')->label(false)->hiddenInput(['value'=>$loan_repayment_id,'readOnly'=>'readOnly']) ?>
<table style="width:100%;"><tr><td>    
            
    <?= $form->field($model, 'amount')->textInput(['value'=>$amount]) ?></td>       
    </tr>
        <tr>
        <td>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>   
    </div>
</td>
</tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>
