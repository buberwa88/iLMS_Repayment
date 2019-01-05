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

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
    ]); ?>

    <?php  
     echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' =>1,
            'attributes' => [               
                'report_id' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Report',
                  'options' => [
                      //'data' => ArrayHelper::map(\common\models\User::find()->where(['login_type' => 5])->all(), 'user_id', 'firstname'),
                      
                      'data' =>ArrayHelper::map(\backend\modules\report\models\Report::findBySql('SELECT id,name FROM `report` INNER JOIN report_access ON report.id=report_access.report_id WHERE report_access.user_role="Help_Desk_Only"')->asArray()->all(), 'id', 'name'),
                      
                       'options' => [
                        'prompt' => 'Select',
                        'multiple'=>TRUE,  
                        
                    ],
                ],
            ],                

            //'comment'=>['label'=>'Comment', 'options'=>['placeholder'=>'Comment']],                 
           ]
           ]);
     ?>

    <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index-popularreport'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>