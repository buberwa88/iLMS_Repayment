 <?php
 use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
     $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
         'enableClientValidation'=>TRUE,
            ]);
     $modelall=new common\models\User();
  //   print_r($model);
 ?>
 <h4>School Name : <font color="green"><?=$model["szExamCentreName"]?></font></h4>
 
 <h4>Full Name : <font color="red"><?=$model["szFirstName"]." ".$model["szOtherNames"]." ".$model["szSurName"];?></font></h4>
 
 <input type="hidden" name="firstname"  value="<?=$model["szFirstName"]?>">
 <input type="hidden" name="middlename"  value="<?=$model["szOtherNames"]?>">
 <input type="hidden" name="surname"  value="<?=$model["szSurName"]?>">
 <input type="hidden" name="sex"  value="<?=$model["szSex"]?>">
 <input type="hidden" name="point"  value="<?=$model["intPoints"]?>">
 <input type="hidden" name="division"  value="<?=$model["szDivision"]?>">
 <input type="hidden" name="institution"  value="<?=$model["szExamCentreName"]?>">
<?php
 echo Form::widget([
        'model' =>$modelall,
        'form' => $form,
        'columns' => 1,
        'id'=>"mickidadi",
        'attributes' => [
            'label' => 'Completion Year',
             
             'validated' => ['label'=>'Click to Confirm the above information','type' => Form::INPUT_CHECKBOX, 'options' => ['placeholder' => 'Enter Require Verification...','onchange'=>'check_status()']],
                  ]
    ]);