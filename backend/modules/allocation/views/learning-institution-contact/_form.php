<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\LearningInstitutionContact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="learning-institution-contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cp_firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp_middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp_surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp_email_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cp_phone_number')->textInput(['maxlength' => true]) ?>
    <?=$form->field($model, 'photo')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
         'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'overwriteInitial'=>false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-camera"></i> ',
        'browseLabel' =>  'Attach Passport Photo (required formate .jpg and .png only)',
          'initialPreview'=>[
            $model->photo==""?"image/no_photo2.png":$model->photo,
           
        ],
        'initialCaption'=>$model->photo==""?"image/no_photo1.png":$model->photo,
        'initialPreviewAsData'=>true,
        
    ]
]);?>
     <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
     <?= $form->field($model, 'is_signator')->dropDownList(

          [1=>'Yes',0=>'No'],
		[
		'prompt'=>'[--Select Status--]',
		// 'onchange'=>'$.post("index.php?r=district/lists&id='.'"+$(this).val(),function(data){
		// 	$("select#models-Regions").html(data);
		// });'
		]
 
    ) ?>
    <?=$form->field($model, 'signature')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
         'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'overwriteInitial'=>false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-camera"></i> ',
        'browseLabel' =>  'Attach Passport Photo ( required formate .jpg and .png only)',
          'initialPreview'=>[
            $model->photo==""?"image/no_photo2.png":$model->signature,
           
        ],
        'initialCaption'=>$model->signature==""?"image/no_photo1.png":$model->signature,
        'initialPreviewAsData'=>true,
        
    ]
]);?>
  
     <?= $form->field($model, 'is_active')->dropDownList(

		[1=>'Active',0=>'InActive'],
		[
		'prompt'=>'[--Select Status--]',
		// 'onchange'=>'$.post("index.php?r=district/lists&id='.'"+$(this).val(),function(data){
		// 	$("select#models-Regions").html(data);
		// });'
		]
 
    ) ?>
    <?= $form->field($model, 'learning_institution_id')->label(false)->hiddenInput(['value'=>Yii::$app->session["learning_institution_id"]]) ?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
