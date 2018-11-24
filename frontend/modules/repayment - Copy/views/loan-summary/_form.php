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
<?= $form->field($model, 'bill_status')->label(false)->hiddenInput(['value'=>'0','readOnly'=>'readOnly']) ?>
<table style="width:100%;"><tr><td>    
            
    <?= $form->field($model, 'employer_name')->textInput(['value'=>$employer_name,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'Employer_Code')->textInput(['value'=>$employer_code,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'bill_number')->textInput(['value'=>$billNumber,'readOnly'=>'readOnly']) ?></td>
    </tr><tr>
        <td><?= $form->field($model, 'traced_by')->textInput(['value'=>'Employer Submission','readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'number_of_employees')->textInput(['value'=>$totalEmployees,'readOnly'=>'readOnly']) ?></td>
        <td><?= $form->field($model, 'amount')->textInput(['value'=>$totalLoanInBill,'readOnly'=>'readOnly']) ?></td>
        </tr><tr>
        <td colspan="3"><?= $form->field($model, 'description')->textarea(['rows' => '3']) ?></td>
        </tr>
        <tr>
        <td colspan="3">
<center>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'SEND BILL' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a('EXIT', ['employer-bill-request-pending'], ['class' => 'btn btn-success']) ?>     
    </div>
</center>
</td>
</tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>
