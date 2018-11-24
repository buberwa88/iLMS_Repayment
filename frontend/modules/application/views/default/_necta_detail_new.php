 <?php
 use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
     $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
         'enableClientValidation'=>TRUE,
            ]);
     $modelall=new common\models\User();
            if(count($model)>0){
               $school_name=$model->institution_name; 
            }
            else{
               $school_name='Unknow School';    
            }
 ?>
 <h4>School Name : <font color="green"><?= $school_name?></font></h4>
  <input type="hidden" name="institution"  value="<?= $school_name?>">
<?php
 echo Form::widget([
        'model' =>$modelall,
        'form' => $form,
        'columns' => 1,
        'id'=>"mickidadi",
        'attributes' => [
           // 'label' => 'Completion Year',
            // 'institution_name' => ['type' => Form::INPUT_HIDDEN, 'options' => ['placeholder' => 'Enter', 'maxlength' => 45,'value'=>$model->institution_name]],
             'validated' => ['label'=>'Click to Confirm the above information','type' => Form::INPUT_CHECKBOX, 'options' => ['placeholder' => 'Enter Require Verification...','onchange'=>'check_status()']],
                  ]
    ]);