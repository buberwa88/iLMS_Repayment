<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-summary-form">

    <?php $form = ActiveForm::begin(['action' => ['loan-summary/loanee-verifyand-approve-bill'],'options' => ['method' => 'post']]); ?>
    <?= $form->field($model, 'Bill_Ref_No')->label(false)->hiddenInput(['value'=>$Bill_Ref_No,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'applicant_id')->label(false)->hiddenInput(['value'=>$applicant_id,'readOnly'=>'readOnly']) ?>
<?= $form->field($model, 'bill_status')->label(false)->hiddenInput(['value'=>'0','readOnly'=>'readOnly']) ?>
<table style="width:100%;"><tr><td>    
            
    <?= $form->field($model, 'fullname')->label('Full Name')->textInput(['value'=>$applicantName,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'reference_number')->textInput(['value'=>$billNumber,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'amountx')->textInput(['value'=>$totalLoanInBill,'readOnly'=>'readOnly']) ?></td>
        </tr><tr>
        <td colspan="3"><?= $form->field($model, 'description')->textarea(['value'=>$billNote,'rows' => '3']) ?></td>
        </tr>
        <tr>
        <td colspan="3">
<center>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Approve Loan Summary' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['loan-summary/loanee-waiting-bill'], ['class' => 'btn btn-warning']); ?>		
    </div>
</center>
</td>
</tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>
