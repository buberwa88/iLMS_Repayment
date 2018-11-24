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

$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>


<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
                 'number_of_rows' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Total Rows',
                  'options' => [
                      'data' => \backend\modules\report\models\Report::getFilterRows(),
                       'options' => [
                        'prompt' => 'Select Rows',
                        
                    ],
                ],
            ],               
   ]
]);	
?>
<div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>
