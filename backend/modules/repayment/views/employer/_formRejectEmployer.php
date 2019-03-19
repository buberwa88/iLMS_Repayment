<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LoanSummary */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employer-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'employerID')->label(false)->hiddenInput(['value'=>$employer_id,'readOnly'=>'readOnly']) ?>
<table style="width:100%;"><tr><td>    
      <tr>
        <td colspan="3"><?= $form->field($model, 'rejection_reason')->textarea(['rows' => '3']) ?></td>
        </tr>
        <tr>
        <td>

    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>     
    </div>

</td>
</tr>
    </table>

    <?php ActiveForm::end(); ?>

</div>