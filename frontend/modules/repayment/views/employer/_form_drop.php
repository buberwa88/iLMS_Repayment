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
?>

<script type="text/javascript">
    function ShowHideDiv() {
        var ddlPassport = document.getElementById("beneficiary-details");
        //var dvPassport = document.getElementById("beneficiary-details");
		//if(ddlPassport.value=="Y"){
        //dvPassport.style.display = ddlPassport.value == "Y" ? "block" : "none";
		dvPassport.style.display = "block";
		//}else{
		//dvPassport.style.display = "none";	
		//}
		var claim_category_value= ddlPassport.value;
                    $.ajax({
                            type   : 'GET',
                            
                            url:"<?= \Yii::$app->getUrlManager()->createUrl('/repayment/refund/refund-claim');?>",
                            data:{claim_category_value:claim_category_value},
                            success: function (data) {
                                if(data==1){
                          document.getElementById('beneficiary-details').style.display = 'block';
                                   }
                                else{
                          document.getElementById('beneficiary-details').style.display = 'none';         
                                }
                          
                            }
                          

                             }) ;
    }
</script>

<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
         'claim_category'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Claim Category',              
                'options' => [
                    'data' => ['1'=>'Non Beneficiary', '2'=>'Over Deduction', '3'=>'Deceased'],
                    'options' => [
                        'prompt' => 'Select Claim Category ',
						'onchange'=>'ShowHideDiv()'
                   
                    ],
                ],
             ],			
    ]
]);
?>
<div id="beneficiary-details" style="display:none">
 <div class="panel panel-info">
        <div class="panel-heading">
        Beneficiary Details
        </div>
        <div class="panel-body">

     <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
             //'beneficiary_f4indexno'=>['options'=>['placeholder'=>'Index Number']],
			 
			 'beneficiary_applicant_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Index Number',
                'options' => [
                    'data' =>ArrayHelper::map(frontend\modules\application\models\Applicant::find()->asArray()->all(), 'applicant_id', 'f4indexno'),
                    'options' => [
                        'prompt' => 'Select Index Number',
                    ],
                ],
            ],
			
			'beneficiary_full_name' => [
                'type' => Form::INPUT_WIDGET,
                'label' => 'Full Name',
                'widgetClass' => DepDrop::className(),
                'options' => [
                    'pluginOptions' => [
                        'depends' => ['refund-beneficiary_applicant_id'],
                        'url' => Url::to(['/repayment/refund/applicant-name']),
                    ],
                ],
                'columnOptions' => ['id' => 'beneficiary_firstnameID'],
            ],
			 
			 
             //'beneficiary_firstname'=>['options'=>['placeholder'=>'First Name']],
             //'beneficiary_middlename'=>['options'=>['placeholder'=>'Middle Name']],
             //'beneficiary_surname'=>['options'=>['placeholder'=>'Last Name']],			 
    ]
]);
?>
        </div>
 </div>
 </div>
<div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>    
	<?php
    echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
	if($upID=='0'){
    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/loan-beneficiary/view-loanee-details-refund','id'=>$applicantID], ['class' => 'btn btn-warning']);
	}else if($upID=='1'){
	echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['index'], ['class' => 'btn btn-warning']);
	}
     ActiveForm::end(); ?>
    </div>


