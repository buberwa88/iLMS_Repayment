<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\CriteriaQuestion */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
?>
 
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
//            var category= document.getElementById('source-value_Id').value;
//            //var cat= document.getElementById('employerId').style.display = 'none';
// 
//     //disbursementbatch-disburse
     updateStatus();
        }
    function updateStatus(){
                         ///alert("mickidadai");
          var category= document.getElementById('source-value_Id').value;
              //  alert(category);
                if(category!=""){
             var cat1= document.getElementById('source-value_Ids').style.display = 'none';         
                  }
                  else{
             var cat1= document.getElementById('source-value_Ids').style.display = '';       
                  }
                  
    }
  
</script> 
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
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
                    'data' => ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'prompt' => 'Academic  Year',
                    
                    ],
                ],
            ],
//      'parent_id' => ['type' => Form::INPUT_WIDGET,
//                'widgetClass' => \kartik\select2\Select2::className(),
//                'label' => 'Parent Criteria',
//                'options' => [
//                    'data' =>ArrayHelper::map(\backend\modules\allocation\models\CriteriaQuestion::find()->where(["criteria_id"=>$model->isNewRecord?$criteria_id:$model->criteria_id])->asArray()->all(), 'criteria_question_id', 'criteria_question_id'),
//                    'options' => [
//                        'prompt' => 'Select Parent Criteria',
//                        //'id'=>'source-table_Id'
//                    
//                    ],
//                ],
//            ],
   'type' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Type',
                'options' => [
                    'data' =>[ 1 =>'Eligibility',2=>'Needness',3=>'Resource'],
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
                    'data' =>ArrayHelper::map(\backend\modules\allocation\models\QresponseList::find()->asArray()->all(), 'qresponse_list_id', 'response'),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['source-table_Id'],
                        
                        'url' => Url::to(['/allocation/criteria/getresponse']),
                    ],
                   'options' => [
                        'prompt' => 'Select ',
                         'id'=>'source-value_Id',
                        'onchange'=>'updateStatus()',
                    
                    ],
                ],
            ],
   //'value'=>['label'=>'Value', 'options'=>['placeholder'=>'Enter Value','id'=>'valueId']],
   
    ]
]);
?>
<div  id="source-value_Ids">
<?= $form->field($model_criteria_question_answer, 'value')->textInput() ?>
</div>
<?= $form->field($model, 'criteria_id')->label(FALSE)->hiddenInput(['value'=>$model->isNewRecord?$criteria_id:$model->criteria_id]) ?>
<div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index', 'id' =>$model->isNewRecord?$criteria_id:$model->criteria_id], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
  </div>

