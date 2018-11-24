 
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">
    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'enableClientValidation' => TRUE,
    ]);
       //$model->loanee_category="";
       echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' =>1,
            'attributes' => [
        'loanee_category' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Applicant  Category',
                'options' => [
                    'data' =>["Local"=>"Local","Overseas"=>"OverSeas"],
                    'options' => [
                        'prompt' => 'Select Applicant Category',
                        
                    ],
                ],
            ],
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

            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
            ?>
            <?= Html::a('Cancel', ['study-view'], ['class' => 'btn btn-warning']) ?>
<?php
ActiveForm::end();
//print_r($model->errors);
?>

            </div>
        </div>
