<script type="text/javascript">
    function ShowHideDivItemApplicableScope() {
        var ddlPassport = document.getElementById("item_applicable_scope_id");
        var item_applicable_scope_value = ddlPassport.value;

        //alert (claim_category_value);
        if (item_applicable_scope_value == 'EMPLOYER') {
            document.getElementById('div_item_applicable_scope').style.display = 'block';
        } else {
            document.getElementById('div_item_applicable_scope').style.display = 'none';

        }
    }
    function ShowHideDivDueLoanCondition() {
        var ddlPassport = document.getElementById("formula_stage_level_id");
        var formula_stage_level_value = ddlPassport.value;

        //alert (claim_category_value);
        if (formula_stage_level_value == '2') {
            document.getElementById('div_repayment_item_level_condition').style.display = 'block';
        } else {
            document.getElementById('div_repayment_item_level_condition').style.display = 'none';

        }
    }
    function ShowHideDivDueLoanGracePeriod() {
        var ddlPassport = document.getElementById("formula_stage_level_condition_id");
        var formula_stage_level_condition_value = ddlPassport.value;

        //alert (claim_category_value);
        if (formula_stage_level_condition_value == '1') {
            document.getElementById('div_repayment_item_level_grace_period').style.display = 'block';
        } else {
            document.getElementById('div_repayment_item_level_grace_period').style.display = 'none';

        }
    }
    function ShowHideDivRepaymentItemType() {
        var loanRepaymentItem = document.getElementById("loan_repayment_item_id");
        var loan_repayment_item_value = loanRepaymentItem.value;

        //alert (claim_category_value);
        if (loan_repayment_item_value == '1') {
            document.getElementById('div_repayment_item_type').style.display = 'block';
        } else {
            document.getElementById('div_repayment_item_type').style.display = 'none';

        }
    }
    /*
     function ShowHideDivRepaymentItemType() {
     var loanRepaymentItem = document.getElementById("loan_repayment_item_id");
     var loan_repayment_item_value= loanRepaymentItem.value;
     //alert (loan_repayment_item_value);
     $.ajax({
     type   : 'GET',
     
     url:"",
     data:{loan_repayment_item_value:loan_repayment_item_value},
     success: function (data) {
     //alert (loan_repayment_item_value);
     if(data==1){
     document.getElementById('div_repayment_item_type').style.display = 'block';
     }
     else{
     document.getElementById('div_repayment_item_type').style.display = 'none'; 
     
     }
     
     }                          
     
     }) ;				
     }
     */
</script>
<?php

//use kartik\password\StrengthValidator;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'loan_repayment_item_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Item Name:',
            'options' => [
                'data' => ArrayHelper::map(backend\modules\repayment\models\LoanRepaymentItem::findBySql('SELECT * FROM `loan_repayment_item` WHERE is_active="1" AND item_code<>"PRC"')->asArray()->all(), 'loan_repayment_item_id', 'item_name'),
                'options' => [
                    'prompt' => 'Select Item',
                //'onchange'=>'ShowHideDivRepaymentItemType()',
                //'id' => 'loan_repayment_item_id',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ],
        ],
        'rate' => ['label' => 'Rate'],
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'rate_type' => [
            'label' => 'Rate Type',
            'type' => Form::INPUT_DROPDOWN_LIST,
            'items' => ['percent' => 'Percent', 'amount' => 'Amount'],
            'options' => [
                'prompt' => 'Select',
                'id' => 'rate_id',
            //'onchange'=>'ShowHideDivRate()',
            ],
        ],
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'charging_interval' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Charging Interval',
            'options' => [
                'data' => \backend\modules\repayment\models\LoanRepaymentSetting::getLoanItemRepaymentChargingInterval(),
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
<?=
$form->field($model, 'start_date')->widget(DatePicker::classname(), [
    'name' => 'start_date',
    //'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
<?=
$form->field($model, 'end_date')->widget(DatePicker::classname(), [
    'name' => 'end_date',
    //'value' => date('Y-m-d', strtotime('+2 days')),
    'options' => ['placeholder' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'item_applicable_scope' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Item Applicable Scope',
            'options' => [
                'data' => \backend\modules\repayment\models\LoanRepaymentSetting::getLoanItemRepaymentiapplicableScope(),
                'options' => [
                    'prompt' => 'Select',
                    'id' => 'item_applicable_scope_id',
                    'onchange' => 'ShowHideDivItemApplicableScope()',
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
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'item_formula' => ['label' => 'Item Formula'],
    ]
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        /* 	
          'formula_stage' => ['type' => Form::INPUT_WIDGET,
          'widgetClass' => \kartik\select2\Select2::className(),
          'label' => 'Formula Stage',
          'options' => [
          'data' => \backend\modules\repayment\models\LoanRepaymentSetting::getLoanItemPaymentFormulaStage(),
          'options' => [
          'prompt' => 'Select',
          'onchange'=>'ShowHideDivRepaymentItemType()',
          ],
          'pluginOptions' => [
          'allowClear' => true
          ],
          ],
          ],
         */
        'formula_stage' => [
            'label' => 'Formula Stage',
            'type' => Form::INPUT_DROPDOWN_LIST,
            'items' => ['0' => 'General', '1' => 'Before Repayment', '2' => 'On Repayment'],
            'options' => [
                'prompt' => 'Select',
                'id' => 'loan_repayment_item_id',
                'onchange' => 'ShowHideDivRepaymentItemType()',
            ],
        ],
    ]
]);
?>
<div id="div_repayment_item_type" style="display:none">
    <?php
    echo Form::widget([ // fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'formula_stage_level' => [
                'label' => 'Stage Level',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ['1' => 'From Disbursement date', '2' => 'Due Loan', '3' => 'On Repayment'],
                'options' => [
                    'prompt' => 'Select',
                    'id' => 'formula_stage_level_id',
                    'onchange' => 'ShowHideDivDueLoanCondition()',
                ],
            ],
        ]
    ]);
    ?>
</div>
<div id="div_repayment_item_level_condition" style="display:none">
    <?php
    echo Form::widget([ // fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'formula_stage_level_condition' => [
                'label' => 'Level Condition',
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ['1' => 'After Graduation', '2' => 'Per Academic Year'],
                'options' => [
                    'prompt' => 'Select',
                    'id' => 'formula_stage_level_condition_id',
                    'onchange' => 'ShowHideDivDueLoanGracePeriod()',
                ],
            ],
        ]
    ]);
    ?>
</div>
<div id="div_repayment_item_level_grace_period" style="display:none">
    <?php
    echo Form::widget([ // fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'grace_period' => ['label' => 'Grace Period(Days)'],
        ]
    ]);
    ?>
</div>
<div id="div_item_applicable_scope" style="display:none">
    <?php
    echo Form::widget([ // fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'employer_type_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employer Type',
                'options' => [
                    'data' => ArrayHelper::map(\backend\modules\repayment\models\EmployerType
                            ::find()->where(['is_active' => 1])->asArray()->all(), 'employer_type_id', 'employer_type'),
                    'options' => [
                        'prompt' => 'Select',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
            'payment_deadline_day_per_month' => ['label' => 'Payment Deadline Day Per Month'],
        ]
    ]);
    ?>
</div>
<?php
echo Form::widget([ // fields with labels
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'loan_repayment_rate' => ['label' => 'Loan Repayment Rate'],
    ]
]);
?>
<?php $model->isNewRecord == 1 ? $model->calculation_mode = 1 : $model->calculation_mode; ?>
<?= $form->field($model, 'calculation_mode')->label('Calculation Mode:')->radioList(array(1 => 'Once at first', '2' => 'Continous')); ?>
<?php $model->isNewRecord == 1 ? $model->is_active = 1 : $model->is_active; ?>
<?= $form->field($model, 'is_active')->radioList(array(1 => 'Yes', '0' => 'No')); ?>
<div class="text-right">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
	echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/loan-repayment-setting/index'], ['class' => 'btn btn-warning']);
    ActiveForm::end();
    ?>
</div>