<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationFramework */
/* @var $form yii\widgets\ActiveForm */
 
?>

<div class="refund-verification-framework-form">
 <div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,
    ]); ?>
  <?php 
  echo $form->field($model, 'support_document')->widget(FileInput::classname(), [
      
      //'options' => ['accept' => 'image/*'],
      'pluginOptions' => [
          'initialPreviewShowDelete' => true,
          'showCaption' => false,
          //'showRemove' => TRUE,
          'showUpload' => false,
          //'browseClass' => 'btn btn-primary btn-block',
          'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
          'browseLabel' =>  'Attach Support Document (required format .pdf,.jpg and .png only)',
          'initialPreview'=>[
              "$model->support_document",
              
          ],
          'initialPreviewConfig' => [
              ['type'=> explode(".",$model->support_document)[1]=="pdf"?"pdf":"image"],
          ],
          'initialCaption'=>$model->support_document,
          'initialPreviewAsData'=>true,
          
      ]
  ]);
  ?>
    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Upload Support Document' : 'Upload Support Document', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
      <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
