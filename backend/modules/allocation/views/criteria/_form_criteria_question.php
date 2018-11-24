 <script type="text/javascript">

 /********************  
  * Id can be hide or show
  * 
	*onload functions
	********************/
	window.onload = start;
	function start () {
		//alert("mickidadi");
		body();
		 
	}
     function body() { 
   //var cat= document.getElementById('criteria-table_Id').style.display = 'none';
       updateStatus();
        }
    function updateStatus(){
       
          var category= document.getElementById('criteria-table_Id').value;
             if(category==1){
             var cat1= document.getElementById('criteria_question_id').style.display = ''; 
              var cat1= document.getElementById('Criteria_Field_id').style.display = 'none';
                  }
                else if(category==2){
          var cat1= document.getElementById('Criteria_Field_id').style.display = ''; 
          var cat1= document.getElementById('criteria_question_id').style.display = 'none';
                }
           
                 
    }
    $('form').on('beforeValidateAttribute', function (event, attribute) {
    if ($(attribute.input).prop('disabled')) { return false; }
});
 </script>
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 ?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'criteria_description'=>['type' => Form::INPUT_TEXTAREA,'label'=>'criteria description', 'options'=>['placeholder'=>'criteria description']],
          'is_active'=>[
            'type'=>Form::INPUT_RADIO_LIST, 
            'items'=>[1=>'Active', 0=>'Inactive'], 
            'label'=>Html::label('Status'), 
            'options'=>['inline'=>true]
        ],
         'criteria_origin' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'criteria Origin from',
                'options' => [
                    'data' =>[ 1 => 'Criteria Question', 2=> 'Criteria Field'],
                    'options' => [
                        'prompt' => 'Operator',
                        'id'=>'criteria-table_Id',
                        'onchange'=>'updateStatus()'
                    
                    ],
                   
                ],
            ],
        
    ]
]);

 ?>
<div id="criteria_question_id" style="display:none">
<hr>
<h4>model_criteria_question</h4>
 
<?php
echo Form::widget([ // fields with labels
    'model'=>$model_criteria_question,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
           'question_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Question',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\Question::find()->asArray()->all(), 'question_id', 'question'),
                    'options' => [
                        'prompt' => 'Question',
                    
                    ],
                ],
            ],
         'operator' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Operator',
                'options' => [
                    'data' =>[ '=' => '=', '>' => '>', '>=' => '>=', '<' => '<', '<=' => '<=', 'IN' => 'IN'],
                    'options' => [
                        'prompt' => 'Operator',
                    
                    ],
                ],
            ],
       'academic_year_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Academic  Year',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'prompt' => 'Academic  Year',
                    
                    ],
                ],
            ],
   'type' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Type',
                'options' => [
                    'data' =>[ 1 =>'Eligibility',2=>'Needness'],
                    'options' => [
                        'prompt' => 'Type',
                    
                    ],
                ],
            ],
   'weight_points'=>['label'=>'Weight Points', 'options'=>['placeholder'=>'Weight Points']],
   'priority_points'=>['label'=>'Priority Points', 'options'=>['placeholder'=>'Priority Points']],
    ]
]);
 
?>
<hr>
<h4>model_criteria_question_answer</h4>
    <?php
 
echo Form::widget([ // fields with labels
    'model'=>$model_criteria_question_answer,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'qresponse_source_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Question Response Source',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\application\models\QresponseSource::find()->asArray()->all(), 'qresponse_source_id', 'source_table'),
                    'options' => [
                        'prompt' => 'Select Question Response Source',
                        'id'=>'source-table_Id'
                    
                    ],
                ],
            ],
         'response_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Response Value',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => \yii::$app->db->schema->getTableNames(),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['source-table_Id'],
                        'placeholder' => 'All Response',
                        'url' => Url::to(['/allocation/criteria/getresponse']),
                    ],
                ],
            ],
   'value'=>['label'=>'Value', 'options'=>['placeholder'=>'Enter Value']],
   
    ]
]);
 
?>
</div>
<div id="Criteria_Field_id" style="display:none">
<hr>
<h4>Criteria Field</h4>
  <?php  //= $form->field($model_Criteria, 'criteria_id')->textInput() ?>

         <?php
 $tableall=\yii::$app->db->schema->getTableNames();
  $source_table=array();
  foreach (  $tableall as   $tablealls=>$value){
   $source_table[$value]=$value;    
  }    
echo Form::widget([ // fields with labels
    'model'=>$model_Criteria,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
        'applicant_category_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Applicant Category',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->asArray()->all(), 'applicant_category_id', 'applicant_category'),
                    'options' => [
                        'prompt' => 'Select Applicant Category',
                    ],
                ],
            ],
         'source_table' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Source Table',
                'options' => [
                    'data' =>$source_table,
                    'options' => [
                        'prompt' => 'Select Source Table',
                        'id'=>'source-table_field_Id'
                    
                    ],
                ],
            ],
    'source_table_field' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Response Value',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => \yii::$app->db->schema->getTableNames(),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['source-table_field_Id'],
                        'placeholder' => 'All Source Table Field',
                        'url' => Url::to(['/allocation/criteria/gettable-column-name']),
                    ],
                ],
            ],
 
   'value'=>['label'=>'Value', 'options'=>['placeholder'=>'Enter Value']],
   'parent_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Parent Cretaria ',
                'options' => [
                    'data' =>ArrayHelper::map(\backend\modules\allocation\models\Criteria::find()->asArray()->all(), 'criteria_id', 'criteria_description'),
                    'options' => [
                        'prompt' => 'Select Parent Cretaria',
                        //'id'=>'source-table_Id'
                    
                    ],
                ],
            ],
    'join_operator' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Join Operator',
                'options' => [
                    'data' =>[ 'AND' => 'AND', 'OR' => 'OR' ],
                    'options' => [
                        'prompt' => 'Select Join Operator',
                       // 'id'=>'source-table_Id'
                    
                    ],
                ],
            ],
   'academic_year_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Academic  Year',
                'options' => [
                    'data' => ArrayHelper::map(backend\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'prompt' => 'Academic  Year',
                    
                    ],
                ],
            ],
   'type' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Type',
                'options' => [
                    'data' =>[ 1 =>'Eligibility',2=>'Needness'],
                    'options' => [
                        'prompt' => 'Type',
                    
                    ],
                ],
            ],
    'weight_points'=>['label'=>'Weight Points', 'options'=>['placeholder'=>'Weight Points']],
    'priority_points'=>['label'=>'Priority Points', 'options'=>['placeholder'=>'Priority Points']],
    ]
]);
 
?>
</div>
  <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);

ActiveForm::end();
?>
    </div>
