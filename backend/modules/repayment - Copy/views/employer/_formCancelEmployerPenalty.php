<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenalty */
/* @var $form yii\widgets\ActiveForm */
$employer=$model->employer->employer_name;
?>

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'employerName')->label('Employer')->textInput(['value'=>$employer,'readOnly'=>'readOnly']) ?>
	<?= $form->field($model, 'amount')->textInput(['value'=>$model->amount,'readOnly'=>'readOnly']) ?>
    <?= $form->field($model, 'penalty_date')->textInput() ?>
    <?= $form->field($model, 'cancel_reason')->textarea(['rows' => '3']) ?>

    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/employer/employer-penalty'], ['class' => 'btn btn-warning']);		
ActiveForm::end();
?>
</div>
