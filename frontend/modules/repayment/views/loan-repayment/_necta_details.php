 <?php
 use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
     $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
         'enableClientValidation'=>TRUE,
            ]);
  //   print_r($model);
 ?>
 <h4>School Name : <font color="green"><?=$model["szExamCentreName"]?></font></h4>
 
 <h4>Full Name : <font color="red"><?=$model["firstname"]." ".$model["middlename"]." ".$model["lastname"];?></font></h4>
<?php
$model=new frontend\modules\repayment\models\RefundNectaData();
 echo Form::widget([
        'model' =>$model,
        'form' => $form,
        'columns' => 1,
        'id'=>"telesphory",
        'attributes' => [
            'label' => 'Completion Year',
             
             'validated' => ['label'=>'Click to Confirm the above information','type' => Form::INPUT_CHECKBOX, 'options' => ['placeholder' => 'Enter Require Verification...','onchange'=>'check_status()']],
                  ]
    ]);
?>