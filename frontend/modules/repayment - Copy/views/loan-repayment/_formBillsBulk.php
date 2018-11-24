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
                'employerId_bulk' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Employer',
                  'options' => [
                      //'data' => ArrayHelper::map(\common\models\User::find()->where(['login_type' => 5])->all(), 'user_id', 'firstname'),
                      
                      'data' =>ArrayHelper::map(\frontend\modules\repayment\models\Employer::findBySql('SELECT loan_repayment.employer_id AS employer_id,employer.employer_name AS employer_name FROM `employer` INNER JOIN loan_repayment ON loan_repayment.employer_id=employer.employer_id WHERE loan_repayment.employer_id=employer.employer_id AND employer.salary_source=1 AND treasury_payment_id IS NULL GROUP BY loan_repayment.employer_id')->asArray()->all(), 'employer_id', 'employer_name'),
                      
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
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['generate-bill-treasury'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>
