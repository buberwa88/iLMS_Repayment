 
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
    function updateStatus(){
      var category= document.getElementById('disbursementschedule-operator_name').value;
                      //alert(category);
             if(category=="Greater than"){
             var cat1= document.getElementById('disbursementscheduleId').style.display = 'none';         
                  }
                else{
          var cat1= document.getElementById('disbursementscheduleId').style.display = '';          
                }
    }
 </script>
 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
    'operator_name' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Loan Board Staff',
                'options' => [
                    'data' => ['Between'=>"Between",'Greater than'=>"Greater than"],
                    'options' => [
                        'prompt' => 'Select Operator',
                        'onchange'=>'updateStatus()'
                       
                    ],
                ],
            ],

    ]
]);
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'from_amount'=>['label'=>'Min Amount', 'options'=>['placeholder'=>'Enter Amount']],
         
      
        
    ]
]);
?>
  <div class="profile-info-row" id="disbursementscheduleId">
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'to_amount'=>['label'=>'Max Amount', 'options'=>['placeholder'=>'Enter Amount']],
          
      
        
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
