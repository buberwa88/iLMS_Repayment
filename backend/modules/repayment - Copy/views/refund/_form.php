<script type="text/javascript">

 /********************  
  * Id can be hide or show
  * 
	*onload functions
	********************/
	window.onload = start;
	function start () {
		beneficiaryDetails();
		 
	}
    function beneficiaryDetails(){
       
          var claim_category_value= document.getElementById('refund-claim_category').value;
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
//use kartik\password\StrengthValidator;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\Refund */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
$claimantDetails=\common\models\LoanBeneficiary::getApplicantDetailsUsingApplicantID($applicantID);
$totalAmountRepaid=\frontend\modules\repayment\models\LoanRepaymentDetail::getAmountTotalPaidLoanee($applicantID);
?>
<div class="panel panel-info">
        <div class="panel-heading">
        Claimant's Details
        </div>
        <div class="panel-body">

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
						'onchange'=>'beneficiaryDetails()'
                   
                    ],
                ],
             ],
             'f4indexno'=>['label'=>'Index Number', 'options'=>['value'=>$claimantDetails->f4indexno,'disabled' => true]],
             'fullname'=>['label'=>'Full Name', 'options'=>['value'=>$claimantDetails->user->firstname." ".$claimantDetails->user->middlename." ".																				$claimantDetails->user->surname,'disabled' => true]],	
             'employee_id'=>['label'=>'Employee ID', 'options'=>['placeholder'=>'Employee ID']],
			 'description'=>['type'=>Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Description...']],	
             'totalAmountRepaid'=>['options'=>['value'=>number_format($totalAmountRepaid,2),'disabled' => true]],
             'amount'=>['options'=>['placeholder'=>'Amount']],			 
		     'employer_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employer',
                'options' => [
                    'data' =>ArrayHelper::map(frontend\modules\repayment\models\Employer::findBySql('SELECT * FROM employer INNER JOIN employed_beneficiary ON employer.employer_id=employed_beneficiary.employer_id WHERE employed_beneficiary.applicant_id="'.$applicantID.'"')->asArray()->all(), 'employer_id', 'employer_name'),
                    'options' => [
                        'prompt' => 'Select Employer',
                    ],
                ],
            ],			
			//'applicant_id'=>['options'=>['value'=>$applicantID,'disabled' => true,'hidden'=>true]],
            'applicant_id'=>['type'=>Form::INPUT_HIDDEN, 'options'=>['value'=>$applicantID]],			
    ]
]);
?>
<?= $form->field($model, 'claimant_letter_received_date')->widget(DatePicker::classname(), [
           'name' => 'claimant_letter_received_date', 
    //'value' => date('Y-m-d', strtotime('+2 days')),
	
    'options' => ['placeholder' => 'yyyy-mm-dd',
                  'todayHighlight' => true,
				  'disabled' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
             'claimant_letter_id'=>['options'=>['placeholder'=>'Enter Claimant Letter ID
']],    		
    ]
]);
?>
<?= $form->field($model, 'claim_decision_date')->widget(DatePicker::classname(), [
           'name' => 'claim_decision_date', 
    //'value' => date('Y-m-d', strtotime('+2 days')),
	
    'options' => ['placeholder' => 'yyyy-mm-dd',
                  'todayHighlight' => true,
				  'disabled' => false,
                 ],
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => false,
    ],
]);
?>
<?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
             'claim_file_id'=>['options'=>['placeholder'=>'Enter Claimant Letter ID
']], 
            'claim_status'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Claim Status',              
                'options' => [
                    'data' => ['1'=>'Stop Deduction', '2'=>'Deduction Not Stopped'],
                    'options' => [
                        'prompt' => 'Select Claim Status ',
                   
                    ],
                ],
             ],   		
    ]
]);
?>
        </div>
 </div>
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
 <div class="panel panel-info">
        <div class="panel-heading">
        Claimant's Contacts and Bank Details
        </div>
        <div class="panel-body">

     <?php
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
            'phone_number'=>['options'=>['placeholder'=>'Telephone Number, e.g 0785986531,0768256981,0658965847']],
            'email_address'=>['options'=>['placeholder'=>'Email Address']],
            'bank_name'=>['options'=>['placeholder'=>'Bank Name']],
            'bank_account_number'=>['options'=>['placeholder'=>'Bank Account Number']], 
            'branch_name'=>['options'=>['placeholder'=>'Branch Name']],			
    ]
]);
?>
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
