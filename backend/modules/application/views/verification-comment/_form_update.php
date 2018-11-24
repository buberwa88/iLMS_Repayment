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
                
                'attachment_definition_id' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Attachment',
                  'options' => [
                      //'data' => ArrayHelper::map(\common\models\User::find()->where(['login_type' => 5])->all(), 'user_id', 'firstname'),
                      
                      'data' =>ArrayHelper::map(\frontend\modules\application\models\AttachmentDefinition::findBySql('SELECT attachment_definition_id,attachment_desc FROM `attachment_definition`')->asArray()->all(), 'attachment_definition_id', 'attachment_desc'),
                      
                       'options' => [
                        'prompt' => 'Select',
                        
                    ],
                ],
            ],
                
                'verification_comment_group_id' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Comment',
                  'options' => [
                      //'data' => ArrayHelper::map(\common\models\User::find()->where(['login_type' => 5])->all(), 'user_id', 'firstname'),
                      
                      'data' =>ArrayHelper::map(\backend\modules\application\models\VerificationCommentGroup::findBySql('SELECT verification_comment_group_id,comment_group FROM `verification_comment_group`')->asArray()->all(), 'verification_comment_group_id', 'comment_group'),
                      
                       'options' => [
                        'prompt' => 'Select',
                        //'multiple'=>TRUE,  
                        
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
echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);

ActiveForm::end();
?>
    </div>
