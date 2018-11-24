<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanRepayment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bill_number')->textInput(['value'=>$model->bill_number,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amountx')->textInput(['value'=>number_format($model->amount,2),'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'totalBeneficiaries')->textInput(['value'=>$totalEmployees,'readOnly'=>'readOnly']) ?>
	<div class="text-right">
		<?= Html::submitButton($model->isNewRecord ? 'Click here to confirm for payment' : 'Click here to confirm for payment', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['treasury-payment/index'], ['class' => 'btn btn-warning']); ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
