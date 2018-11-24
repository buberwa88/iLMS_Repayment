<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Cnotification $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="cnotification-form">

    <?php 
    
    $typeList = [
        'GENERAL'=>'GENERAL',
        'ACCOUNT_CREATED'=>'ACCOUNT_CREATED',
        'ACCOUNT_ACTIVATED'=>'ACCOUNT_ACTIVATED',
        'PAYMENT_CONFIRMED'=>'PAYMENT_CONFIRMED'
    ];
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'type' => ['type' => Form::INPUT_DROPDOWN_LIST,'items'=>$typeList],
            'subject' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Subject...', 'maxlength' => 255]],

            'notification' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \dosamigos\ckeditor\CKEditor::className(),
            ],
            
            //'notification' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter Notification...','rows' => 6]],
            
            //'date_created' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

        ]

    ]);

    echo Html::submitButton('Back',
        ['class' => 'btn btn-success']
    ).'&nbsp;&nbsp;&nbsp'.Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
