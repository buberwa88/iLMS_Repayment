<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\repayment\models\LoanRepaymentItem;
use kartik\date\DatePicker;
//use kartik\field\FieldRange;
//use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\LoanRepaymentSetting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="loan-repayment-setting-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-sm-8">
       <div class="profile-user-info profile-user-info-striped">
           <div class="profile-info-row">
        <div class="profile-info-name">
            <label class="control-label" for="email">Item Name:</label>
        </div>
      <div class="profile-info-value">
    <div class="col-sm-12">
     <?= $form->field($model, 'loan_repayment_item_id')->label(false)->dropDownList(
                                ArrayHelper::map(LoanRepaymentItem::find()->all(), 'loan_repayment_item_id', 'item_name'),['prompt'=>'Select Item']
                    ) ?> 
       </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Starting Date:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">      
        <?= $form->field($model, 'start_date')->label(false)->widget(DatePicker::classname(), [
           'name' => 'start_date', 
    'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'Select start date ...',
                  'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-m-dd',
        'todayHighlight' => true,
    ],
]);
    ?>        
        
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">End Date:</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
<?= $form->field($model, 'end_date')->label(false)->widget(DatePicker::classname(), [
           'name' => 'end_date', 
    'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'Select end date ...',
                  'todayHighlight' => true,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-m-dd',
        'todayHighlight' => true,
    ],
]);
    ?>
    </div>
        </div>
            </div>
           <div class="profile-info-row">
        <div class="profile-info-name">
          <label class="control-label" for="email">Percent(%):</label>
        </div>
        <div class="profile-info-value">
    <div class="col-sm-12">
    <?= $form->field($model, 'percent')->label(false)->textInput(['maxlength' => true]) ?>        
    </div>
        </div>
            </div>
           </div>
<div class="space10"></div>
     <div class="col-sm-12">
    <div class="form-group button-wrapper">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
     </div>
    <?php ActiveForm::end(); ?>

</div>
</div>
<div class="space10"></div>
