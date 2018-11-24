<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);

echo Form::widget([// fields with labels
    'model' => $verification_item,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'verification_framework_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'attachment_definition_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\application\models\AttachmentDefinition::find()
                                                                                                 ->where(['is_active'=>1])
                                                                                                  ->asArray()->all(), 'attachment_definition_id', 'attachment_desc'),
                    'options' => [
                        'prompt' => 'Select',
                    ],
                ],
            ],
         'verification_prompt' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '-- Select --',
                'multiple' => TRUE,
            ],
        ],
        'category'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Category',
              
                'options' => [
                    'data' => ['1'=>'Mandatory', '2'=>'Option'],
                    'options' => [
                        'prompt' => 'Select ',
                   
                    ],
                ],
             ],

    ]
]);
?>

<div class="text-right">
    <?= Html::submitButton($verification_item->isNewRecord ? 'Create' : 'Update', ['class' => $verification_item->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/application/verification-framework/view','id'=>$verification_framework_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
