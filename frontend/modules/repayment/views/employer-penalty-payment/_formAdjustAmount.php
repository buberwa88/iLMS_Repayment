<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenaltyPayment */
/* @var $form yii\widgets\ActiveForm */
$totalAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmount($employerID);
$paidAmount=frontend\modules\repayment\models\EmployerPenaltyPayment::getTotalPenaltyAmountPaid($employerID);
$outstandingAmount=$totalAmount-$paidAmount;
$getExists=\frontend\modules\repayment\models\EmployerPenaltyPayment::find()
->where(['employer_id'=>$employerID,'payment_status'=>0]);
?>

<div class="employer-penalty-payment-form">
	<?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'amount')->label('Pay Amount')->textInput(['value'=>$outstandingAmount]) ?>
   <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['employer-penalty-payment/create'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>

</div>

