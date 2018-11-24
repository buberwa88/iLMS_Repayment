<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'item_name'=>['label'=>'Item Name:', 'options'=>['placeholder'=>'Item Name:']],	
        'item_code'=>['label'=>'Item Code:', 'options'=>['placeholder'=>'Item Code:']],		
    ]
]);
?>
 <?php $model->isNewRecord==1 ? $model->is_active=1:$model->is_active;?>
 <?= $form->field($model, 'is_active')->radioList(array(1=>'Active','0'=>'Inactive')); ?>
  <div class="text-right">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	 <?php echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/loan-repayment-item/index'], ['class' => 'btn btn-warning']);?>
  
<?php
ActiveForm::end();
?>
    </div>