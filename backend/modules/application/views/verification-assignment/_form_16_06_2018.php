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
               'study_level' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Study Level',
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                       'options' => [
                        'prompt' => 'Select Study Level',
                        
                    ],
                ],
            ],
            'total_applications' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Number of Applications',
                'options' => [
                    'data' =>[10 => 10,50 => 50,100 => 100,150 => 150,200 => 200],
                    'options' => [
                        'prompt' => 'Select # of Applications',
                        
                    ],
                ],
            ],

            'assignee' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Assignee',
                  'options' => [
                      'data' => ArrayHelper::map(\common\models\User::find()->where(['login_type' => 5])->all(), 'user_id', 'firstname'),
                       'options' => [
                        'prompt' => 'Select Assignee',
                        
                    ],
                ],
            ],
           
           ]
           ]);
     ?>

    <div class="text-right">
       <?= Html::submitButton($model->isNewRecord ? 'Assign' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/application/verification-assignment'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>
