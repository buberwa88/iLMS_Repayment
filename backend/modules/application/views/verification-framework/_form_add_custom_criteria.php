<script type="text/javascript">
    function ShowHideDiv() {
        var ddlPassport = document.getElementById("source-table_field_Id");
		var claim_category_value= ddlPassport.value;
		
		//alert (claim_category_value);
                if(claim_category_value=='date_of_birth'){
                          document.getElementById('source-table_field_value_Id2').style.display = 'block';
                          document.getElementById('source-table_field_value_Id').style.display = 'none';
                                   }
                                else{
                          document.getElementById('source-table_field_value_Id').style.display = 'block';
                          document.getElementById('source-table_field_value_Id2').style.display = 'none';
                          						  
                                }
    }
</script>

<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\date\DatePicker;


// form with an id used for action buttons in footer
// form with an id used for action buttons in footer
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);//, [
            //'enableAjaxValidation' => true,
            //'method' => 'POST',
            //'action' => ['verification-framework/add-custom-criteria', 'id' => $model->verification_framework_id],
        //]);

echo Form::widget([// fields with labels
    'model' => $model_custom_criteria,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'verification_framework_id' => ['type' => Form::INPUT_HIDDEN,
        ],
        'criteria_name' => ['type' => Form::INPUT_TEXT,
            'options' => [
                'prompt' => '--Criteria Name--',
            ],
        ],
        'applicant_source_table' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Source Table',
            'options' => [
                //'data' => ArrayHelper::map(\backend\modules\allocation\models\SourceTable::find()->all(), 'source_table_id', 'source_table_name'),
                'data' => \backend\modules\allocation\models\AllocationPlan::getSchemaTablesList(),
                'options' => [
                    'prompt' => 'Select Source Table',
                    'id' => 'source-table_Id'
                ],
            ],
        ],
        'applicant_souce_column' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\depdrop\DepDrop::className(),
            'label' => 'Source Table Columns',
            'options' => [
//                'data' => Yii::$app->db->schema->getTableSchema('applicant')->columnNames,
                'options' => [
                    'prompt' => 'Select Source column ',
                    'id' => 'source-table_field_Id',
                    'onchange'=>'ShowHideDiv()',
                ],
                'pluginOptions' => [
                    'depends' => ['source-table_Id'],
                    'loading' => true,
                    'placeholder' => '-- Select --',
                    'initialize' => true,
                    'url' => \yii\helpers\Url::to(['/allocation/allocation-plan/table-columns']),
                    'loadingText' => 'Loading ...'
                ]
            ],
        ],        
]]);
?>
<div id="source-table_field_value_Id" style="display:none">
<?php
echo Form::widget([// fields with labels
    'model' => $model_custom_criteria,
    'form' => $form,
    'columns' => 1,
    'attributes' => [        
        'column_value1' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\depdrop\DepDrop::className(),
            'label' => 'Columns Value',
            'options' => [
//                'data' => Yii::$app->db->schema->getTableSchema('applicant')->columnNames,
                'options' => [
                    'prompt' => 'Select Source column ',
                    //'id' => 'source-table_field_value_Id'
                ],
                'pluginOptions' => [
                    'depends' => ['source-table_Id', 'source-table_field_Id'],
                    'loading' => true,
                    'placeholder' => '-- Select --',
                    'initialize' => true,
                    'url' => \yii\helpers\Url::to(['/allocation/allocation-plan/column-values']),
//                    'loadingText' => 'Loading ...'
                ]
            ],
        ],
]]);
?>
</div>    
<div id="source-table_field_value_Id2" style="display:none">
<?= $form->field($model_custom_criteria, 'column_value2')->widget(DatePicker::classname(), [
           'name' => 'column_value2', 
    //'value' => date('Y-m-d', strtotime('+2 days')),
	
    'options' => ['placeholder' => 'yyyy-mm-dd',
                  'todayHighlight' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
</div>
<?php
echo Form::widget([// fields with labels
    'model' => $model_custom_criteria,
    'form' => $form,
    'columns' => 1,
    'attributes' => [               
        'operator' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'options' => [
                'data' => \backend\modules\allocation\models\AllocationPlanSpecialGroup::getOperators(),
                'options' => [
                    'prompt' => '-- Select --',
                ],
            ],
        ],
]]);
?>
<div class="text-right">
    <?= Html::submitButton($model_custom_criteria->isNewRecord ? 'Create' : 'Update', ['class' => $model_custom_criteria->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['/application/verification-framework/view','id'=>$verification_framework_id], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
    ?>
</div>
