<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="file-upload-form">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
           <div class="error_container" style="color: red"><?= $form->errorSummary($model); ?></div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Upload Payment Recon. Excel File:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
   <?= $form->field($model, 'controlNumberFile')->label(false)->fileInput() ?>
    </div>
        </div>
            </div>
</div>
<div class="space10"></div>
     <div class="col-sm-12">
	 <br/>
	 <div class="text-right">
    <div class="form-group button-wrapper">
    <button style="width:180px;">Upload</button>
</div>
</div>
     </div>
<?php ActiveForm::end() ?>

    </div>
</div>
   <div class="space10"></div>