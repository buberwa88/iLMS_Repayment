<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use frontend\modules\repayment\models\EmployerSearch;
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
        'bill_type'=>['label'=>'Bill Type:', 'options'=>['placeholder'=>'Bill Type']],
        'bill_processing_uri'=>['label'=>'Bill Processing URI:', 'options'=>['placeholder'=>'Bill Processing URI']],
        'bill_prefix'=>['label'=>'Prefix:', 'options'=>['placeholder'=>'Prefix']],
        'bill_prefix'=>['label'=>'Prefix:', 'options'=>['placeholder'=>'Prefix','onkeyup'=>"this.value = this.value.toUpperCase();"]],
        'operation_type' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Operation Type:',
            'options' => [
                'data' => backend\modules\repayment\models\GepgBillProcessingSetting::getOperationTypeGePGSetting(),
                'options' => [
                    'prompt' => 'Select',
                    //'id' => 'applicant_category_id',

                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
    ]
]);
?>
	<div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);	
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/gepg-bill-processing-setting/index'], ['class' => 'btn btn-warning']);
?>
</div>

<?php ActiveForm::end(); ?>