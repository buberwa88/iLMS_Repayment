<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \backend\modules\repayment\models\EmployedBeneficiary;
use frontend\modules\repayment\models\LoanRepayment;
/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
$results=LoanRepayment::getDetailsUsingRepaymentID($model->loan_repayment_id);
$outstandingDebt=number_format(frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($results->applicant_id),2);
//echo $loan_repayment_id;

?>

<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'bill_number')->textInput(['value'=>$model->bill_number,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'repaymentID')->label(false)->hiddenInput(['value'=>$model->loan_repayment_id,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'loan_summary_id')->label(false)->hiddenInput(['value'=>$results->loan_summary_id,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'outstandingDebt')->label('Outstanding Debt')->textInput(['value'=>$outstandingDebt,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'amountApplicant')->label(false)->hiddenInput(['value'=>$model->amount,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amount')->textInput(['value'=>$model->amount]) ?>
    <div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['loan-repayment/index-beneficiary'], ['class' => 'btn btn-warning']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
