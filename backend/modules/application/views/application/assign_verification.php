<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\ApplicationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="application-search">

    <?php $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
    ]); ?>

    <?php  
     echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' =>1,
            'attributes' => [
               'applicant_category_id' => ['type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\select2\Select2::className(),
                  'label' => 'Study Level',
                  'options' => [
                      'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                       'options' => [
                        'prompt' => 'Select Study Level',
                        
                    ],
                ],
            ],
            'number_of_applications' => ['type' => Form::INPUT_WIDGET,
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
        <?= Html::submitButton('Assign', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

