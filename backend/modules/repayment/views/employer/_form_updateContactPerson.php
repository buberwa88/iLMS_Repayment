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
		'phone_number'=>['label'=>'Telephone Number:', 'options'=>['placeholder'=>'Telephone Number']],	 
		'email_address'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address'],
		],
]]);
?>

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
