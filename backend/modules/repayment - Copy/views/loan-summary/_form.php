<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-summary-form">

    <?php $form = ActiveForm::begin(['action' => ['loan-summary/create'],'options' => ['method' => 'post']]); ?>
    <?= $form->field($model, 'employer_id')->label(false)->hiddenInput(['value'=>$employer_id,'readOnly'=>'readOnly']) ?>
<?= $form->field($model, 'status')->label(false)->hiddenInput(['value'=>'0','readOnly'=>'readOnly']) ?>
<table style="width:100%;"><tr><td>    
            
    <?= $form->field($model, 'employer_name')->label('Employer')->textInput(['value'=>$employer_name,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'Employer_Code')->textInput(['value'=>$employer_code,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'reference_number')->label('Loan Summary Number')->textInput(['value'=>$billNumber,'readOnly'=>'readOnly']) ?></td>
    </tr><tr>
        <td><?= $form->field($model, 'traced_by')->textInput(['value'=>'Employer Submission','readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'number_of_employees')->textInput(['value'=>$totalEmployees,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'amountx')->textInput(['value'=>$totalLoanInBill,'readOnly'=>'readOnly']) ?></td>
        </tr><tr>
        <td colspan="3"><?= $form->field($model, 'description')->textarea(['value'=>$billNote,'rows' => '3']) ?></td>
        </tr>
        <tr>
        <td colspan="3">

    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Approve Loan Summary' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['employed-beneficiary/employer-waiting-loan-summary'], ['class' => 'btn btn-warning']); ?>		
    </div>

</td>
</tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>
