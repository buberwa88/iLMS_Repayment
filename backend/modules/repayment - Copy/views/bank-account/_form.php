<?php

//use kartik\password\StrengthValidator;
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
	            'bank_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Bank Name:',
                'options' => [
                    'data' =>ArrayHelper::map(backend\modules\application\models\Bank::find()->asArray()->all(), 'bank_id', 'bank_name'),
                    'options' => [
                        'prompt' => 'Select Bank',
                    ],
                ],
            ],
            'branch_name'=>['label'=>'Branch Name:', 'options'=>['placeholder'=>'Branch Name:']],
            'account_name'=>['label'=>'Account Name:', 'options'=>['placeholder'=>'Account Name:']],
            'account_number'=>['label'=>'Account Number:', 'options'=>['placeholder'=>'Account Number:']],	
            'currency_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Currency:',
                'options' => [
                    'data' =>ArrayHelper::map(backend\modules\allocation\models\Currency::find()->asArray()->all(), 'currency_id', 'currency_code'),
                    'options' => [
                        'prompt' => 'Select Currency',
                    ],
                ],
            ],			
    ]
]);
?>
<div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/bank-account/index'], ['class' => 'btn btn-warning']);
ActiveForm::end();
?>
    </div>