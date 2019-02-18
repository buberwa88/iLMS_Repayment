<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

$list=\backend\modules\repayment\models\RefundInternalOperationalSetting::getUserRoles();

// form with an id used for action buttons in footer
// form with an id used for action buttons in footer
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);//, [
            //'enableAjaxValidation' => true,
            //'method' => 'POST',
            //'action' => ['verification-framework/add-custom-criteria', 'id' => $model->verification_framework_id],
        //]);

echo Form::widget([// fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'firstname' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '--firstname--',
            ],
        ],
		'middlename' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '--middlename--',
            ],
        ],
		'surname' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '--surname--',
            ],
        ],
		'sex'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Sex',
              
                'options' => [
                    'data' => ['M'=>'Male', 'F'=>'Female'],
                    'options' => [
                        'prompt' => 'Select Gender ',
                   
                    ],
                ],
             ],
		'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],	 
		'email_address'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address'],
		],
		/*
		'staffLevel'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Level',
              
                'options' => [
                    'data' => ['1'=>'Supervisor', '2'=>'Normal Staff'],
                    'options' => [
                        'prompt' => 'Select',
                   
                    ],
                ],
             ],
*/
        'staffLevel' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Role',
            'options' => [
                'data' =>$list,
                'options' => [
                    'prompt' => 'Select',
                    'multiple'=>TRUE,

                ],
            ],
        ],

		'password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Password:', 'options'=>['placeholder'=>'Password'],
		],
		'confirm_password'=>['type'=>Form::INPUT_PASSWORD,'label'=>'Retype Password:', 'options'=>['placeholder'=>'Retype Password']],
]]);
?>

<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/repayment/default/add-user'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
