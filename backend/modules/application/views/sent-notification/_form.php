<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use frontend\modules\application\models\Cnotification;
use frontend\modules\application\models\SentNotification;

/**
 * @var yii\web\View $this
 * @var app\models\SentNotification $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="sent-notification-form">

    <?php 
    
    
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); 
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'cnotification_id' => ['type' => Form::INPUT_DROPDOWN_LIST,   'label'=>'Subject',    'items'=>  \yii\helpers\ArrayHelper::map(Cnotification::find()->all(), 'cnotification_id', 'subject'), 'options' => ['prompt' => '--Select-----']],
            //'description' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Description...', 'maxlength' => 150]],
            'sms_text' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Leave blank if not applicable', 'maxlength' => 255]],
            

            //'user_sent' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter User Sent...']],

           // 'date_sent' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

        ]

    ]);
    
    
 echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [

             'target_group' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=>  SentNotification::getTargetGroups(),    'options' => ['prompt' => '---Select---']],
             'repeat_every' => ['type' => Form::INPUT_DROPDOWN_LIST,  'items'=> [0=>'Never Repeat',1=>'1 Day',2=>'2 Days',3=>'3 Days',4=>'4 Days',5=>'5 Days',6=>'6 Days',7=>'7 Days',8=>'8 Days',9=>'9 Days',10=>'10 Days'] ,  'options' => ['prompt' => '--Select-----']],
            

            //'user_sent' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter User Sent...']],

           // 'date_sent' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send Notification') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']
    );
    ActiveForm::end(); ?>

</div>
