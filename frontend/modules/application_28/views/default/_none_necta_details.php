 <?php
 use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
     $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
         'enableClientValidation'=>TRUE,
            ]);

 ?>

<?php
 echo Form::widget([
        'model' =>$modelall,
        'form' => $form,
        'columns' => 2,
        'id'=>"mickidadi",
        'attributes' => [
             'firstname' => ['type' => Form::INPUT_TEXT,'label'=>'First Name', 'options' => ['placeholder' => 'Enter ']],
             'middlename' => ['type' => Form::INPUT_TEXT,'label'=>'Middle Name', 'options' => ['placeholder' => 'Enter .']],
                  ]
    ]);
  echo Form::widget([
        'model' =>$modelall,
        'form' => $form,
        'columns' => 2,
        'id'=>"mickidadi2",
        'attributes' => [
             'surname' => ['type' => Form::INPUT_TEXT,'label'=>'Last Name', 'options' => ['placeholder' => 'Enter ']],
             'sex' => [
            'type' =>  Form::INPUT_DROPDOWN_LIST, 
            'items'=>['M'=>'Male','F'=>'Female'],
            'prompt' => 'Select Gender',
                ],
                ]
    ]);
 ActiveForm::end();
 