<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgReconMaster */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'recon_date')->label('Reconciliation Date')->widget(DatePicker::classname(), [
           'name' => 'start_date', 
    'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'Select reconciliation date ...',
                  'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
    ?>
	<?= $form->field($model, 'description')->textarea(['rows' => '3']) ?>

   <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/application/gepg-recon-master/index'], ['class' => 'btn btn-warning']);
ActiveForm::end();
?>
</div>
