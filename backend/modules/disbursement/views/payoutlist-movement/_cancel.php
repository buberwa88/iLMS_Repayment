<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovement */
/* @var $form yii\widgets\ActiveForm */
//find the latest move of this batch
   $modelmove=  backend\modules\disbursement\models\PayoutlistMovement::find()->where(['disbursements_batch_id'=>$disbursementId])->limit(1)->orderBy(['movement_id' => SORT_DESC])->asArray()->all();
//end
    $userId=""; 
   if(count($modelmove)>0){
                     foreach ($modelmove as   $modelmoves);
                     $userId=$modelmoves["from_officer"];
   }
 
?>

<div class="payoutlist-movement-form">

    <?php $form = ActiveForm::begin(); ?>
  <div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
       
 
             <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Comment:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'comment')->label(false)->textArea(['row' => 4]) ?>
    <?= $form->field($model, 'date')->label(false)->hiddenInput(["value"=>date("Y-m-d")]) ?>
 </div>
        </div>
            </div>
          
       </div>
       
  </div>
    
     <?= $form->field($model, 'disbursements_batch_id')->label(false)->hiddenInput(["value"=>$disbursementId]) ?>
    <?= $form->field($model, 'from_officer')->label(false)->hiddenInput(['value'=>\yii::$app->user->identity->user_id]) ?>
     <?= $form->field($model, 'to_officer')->label(false)->hiddenInput(['value'=>$userId]) ?>
  
     <div class="col-sm-12">
          <div class="space10"></div>
    <div class="form-group button-wrapper">
         <div class="space10"></div>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
     </div>
    <?php ActiveForm::end(); ?>

</div>
   <div class="space10"></div>
