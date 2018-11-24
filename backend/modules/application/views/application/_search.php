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
                'action' => [$action],
                'method' => 'get',
    ]); ?>

    <?php  
     echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' =>2,
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
           
           ]
           ]);
     ?>

    <div class="text-right">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
