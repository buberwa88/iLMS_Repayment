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
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 ?>
 <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'criteria_description'=>['type' => Form::INPUT_TEXTAREA,'label'=>'criteria description', 'options'=>['placeholder'=>'criteria description']],
       
            //'type'=>Form::INPUT_RADIO_LIST, 
           // 'items'=>[1=>'Active', 0=>'Inactive'], 
            'is_active'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Status',
                'options' => [
                    'data' =>[1=>'Active', 0=>'Inactive'],
                    'options' => [
                   
                    ],
                ],
            ],
       
    ]
]);

 ?>
  
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