<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\appeal\models\ComplaintCategory;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\Complaint */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complaint-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'complaint_category_id')
             ->dropdownList(ComplaintCategory::find()
                            ->select(['complaint_category_name'])
                            ->indexBy('complaint_category_id')
                            ->column(),['prompt'=>'Select Category']);
    ?>

    <div class="form-group">
        <?= Html::label("Complaint Category") ?>
        <?= Html::dropDownList('type', null, [''=>'Select Type','group'=>'Group', 'individual'=>'Individual'], ['id'=>'type','class'=>'form-control']) ?>
    </div>

    <br/>
    <div class="form-group" style="display: none" id="formIndexNumberContainer">
        <?= Html::label("Form Four Index Number") ?>
        <?= Html::textInput('indexNumber', null,['id'=>'type','class'=>'form-control']) ?>
    </div>

    <br/>
    <div class="form-group">
        <?= $form->field($model, 'complaint')->textarea(['rows' => 6]) ?>
    </div>

    <br/>
    <div class="form-group">
    
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger pull-right', 'style'=>'margin-left:20px']) ?>

        <?= Html::submitButton($model->isNewRecord ? 'Save As Draft' : 'Update Draft', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary  pull-right', 'style'=>'margin-left:20px']) ?>

        <?= Html::resetButton('Reset', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary  pull-right']) ?>

    </div>

  
    <?php ActiveForm::end(); ?>


</div>

<?php
    $this->registerJs('
            $("#type").change(function(){
                
                var type = $(this).val();

                if(type == "individual"){
                    $("#formIndexNumberContainer").css("display","block");
                }else{
                    $("#formIndexNumberContainer").css("display","none");
                }
                
            })'
    );
?>


