 
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
 
   //disbursementbatch-disburse
     updateStatus();
        }
    function updateStatus(data){
      var category= data.value;
                  //alert(category);
             if(category=="Greater than"){
       //   document.getElementsByClassName("field-allocationfeefactor-max_amount").style.display = 'none';  
            	 $(".field-allocationfeefactor-max_amount").hide();       
                  }
                else{
                	 $(".field-allocationfeefactor-max_amount").show();          
                }
    }
 </script>
 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
    'academic_year_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'options' => [
                    'data' =>ArrayHelper::map(\common\models\AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                    'options' => [
                        'prompt' => 'Select Operator',
                        //'onchange'=>'updateStatus()'
                       
                    ],
                ],
            ],
    'operator_name' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                //'label' => 'Loan Board Staff',
                'options' => [
                    'data' => ['Between'=>"Between",'Greater than'=>"Greater than"],
                    'options' => [
                        'prompt' => 'Select Operator',
                        'onchange'=>'updateStatus(this)'
                       
                    ],
                ],
            ],
        'min_amount'=>['label'=>'Min Amount', 'options'=>['placeholder'=>'Enter Amount']],
        'max_amount'=>['label'=>'Max Amount', 'options'=>['placeholder'=>'Enter Amount']],
        'factor_value'=>['label'=>'Factor Value', 'options'=>['placeholder'=>'Enter Amount']],
    ]
]);
 
 ?>
 
  </div>
  <div class="text-right">
        
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
 
    </div>
