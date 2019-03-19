<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;


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
]]);
?>
<?=
$form->field($model, 'phone_number')->label('Telephone Number:')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '255 999 999 999',
    //'options' => ['data-toggle' => 'tooltip',
    //'data-placement' => 'top', 'title' => 'Phone Number eg 07XXXXXXXX or 06XXXXXXXX or 0XXXXXXXXX']
])->hint('Phone Number eg 255 7XXXXXXXX or 255 6XXXXXXXX or 255 XXXXXXXXX');
?>
<?php
echo Form::widget([// fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'email_address'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address'],
        ],
    ]]);
?>
<?php $model->isNewRecord==1 ? $model->status=10:$model->status;?>
 <?= $form->field($model, 'status')->radioList(array(10=>'Active','0'=>'Inactive')); ?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/repayment/employer/view','id' => $employer_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
