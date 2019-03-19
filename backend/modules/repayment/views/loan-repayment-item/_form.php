<script type="text/javascript">
    function ShowHideDiv() {
        var ddlPassport = document.getElementById("payable_status_id");
		var payable_status_value= ddlPassport.value;
		
		//alert (claim_category_value);
                if(payable_status_value=='1'){
                          document.getElementById('div_payable_status').style.display = 'block';
                                   }
                                else{
                          document.getElementById('div_payable_status').style.display = 'none';
                          						  
                                }
    }
    function ShowHideDivParentChild() {
        var ddlPassport = document.getElementById("is_parent_child_id");
		var is_parent_child_value= ddlPassport.value;
		
		//alert (claim_category_value);
                if(is_parent_child_value=='2'){
                          document.getElementById('div_is_parent_child').style.display = 'block';
                                   }
                                else{
                          document.getElementById('div_is_parent_child').style.display = 'none';
                          						  
                                }
    }
</script>
<?php 
if (!$model->isNewRecord && $model->parent_id > 0) {
    $model->is_parent_child = 2;
}
if (!$model->isNewRecord && $model->parent_id ==NULL) {
    $model->is_parent_child = 1;
}
?>
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'item_name'=>['label'=>'Item Name:', 'options'=>['placeholder'=>'Item Name:']],	
        //'item_code'=>['label'=>'Item Code:', 'options'=>['placeholder'=>'Item Code:']],
        'item_code' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Item Code:',
            'options' => [
                'data' => \backend\modules\repayment\models\LoanRepaymentItem::getLoanRepaymentItemList(),
                'options' => [
                    'prompt' => 'Select ',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
    ]
]);
?>
<?php
/*
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'payable_status'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Payment Order',              
                'options' => [
                    'data' => ['0'=>'Independent', '1'=>'List'],
                    'options' => [
                        'prompt' => 'Select ',
			'onchange'=>'ShowHideDiv()',
                    ],
                    //'pluginOptions' => [
                    //'allowClear' => true
                    //],
                ],
             ],			
    ]
]);
 * 
 */
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[  
        'is_parent_child' => [
                'label' => 'Is Parent?', 
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ['1'=>'Yes', '2'=>'No'],
                'options' => [
                        'prompt' => 'Select',
                        'id' => 'is_parent_child_id',
                        'onchange'=>'ShowHideDivParentChild()',
                    ],
              ],			         			
    ]
]);
?>
<div id="div_is_parent_child" style="display:none">
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[         			
		'parent_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Parent',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\repayment\models\LoanRepaymentItem::find()->where(['parent_id'=>NULL])->asArray()->all(), 'loan_repayment_item_id', 'item_name'), 
                    'options' => [
                        'prompt' => 'Select',						
                    ],
                    'pluginOptions' => [
                    'allowClear' => true
                    ],
                ],
            ],
    ]
]);
?>
</div>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        'payable_status' => [
                'label' => 'Payment Order', 
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ['0'=>'Independent', '1'=>'List'],
                'options' => [
                        'prompt' => 'Select',
                        'id' => 'payable_status_id',
                        'onchange'=>'ShowHideDiv()',
                    ],
              ],			         			
    ]
]);
?>
<div id="div_payable_status" style="display:none">
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[         			
		'payable_order_list' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Order List',
                'options' => [
                    'data' => \backend\modules\repayment\models\LoanRepaymentItem::getLoanItemPaymentOrderList(), 
                    'options' => [
                        'prompt' => 'Select',						
                    ],
                    'pluginOptions' => [
                    'allowClear' => true
                    ],
                ],
            ],
        'payable_order_list_status' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Order Condition',
                'options' => [
                    'data' => \backend\modules\repayment\models\LoanRepaymentItem::getLoanItemPaymentOrderListCondition(), 
                    'options' => [
                        'prompt' => 'Select',						
                    ],
                    'pluginOptions' => [
                    'allowClear' => true
                    ],
                ],
            ],
    ]
]);
?>
</div>
<?php $model->isNewRecord==1 ? $model->is_active=1:$model->is_active;?>
 <?= $form->field($model, 'is_active')->radioList(array(1=>'Active','0'=>'Inactive')); ?>
  <div class="text-right">
      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	 <?php
      echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
      echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/loan-repayment-item/index'], ['class' => 'btn btn-warning']);?>
  
<?php
ActiveForm::end();
?>
    </div>