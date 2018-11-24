<meta http-equiv="refresh" content="5">
 
<?php 
use frontend\modules\application\models\Application;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Applicant;
//$amount = 50000;
//$control_number = 108899333;
        $user_id = Yii::$app->user->identity->id;
        $modelUser = \common\models\User::findOne($user_id);
        $modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
        $modelApplication = \frontend\modules\application\models\Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
          
$controlNumberDetails=\backend\modules\application\models\Application::getControlNumber($user_id);
//   $modelApplication->receipt_number="35233252";
//   $modelApplication->control_number="3523523";
?>
<div style="width: 95%">
<?php
use yii\helpers\Html;
$this->title = 'Application Fee';
$this->params['breadcrumbs'][] = ['label'=>'My Application','url'=>['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;


//$this->context->layout = 'simple_layout_no_loading';


//$amount = 50000;
//$control_number = 108899333;
$amount=$controlNumberDetails->amount_paid;
$control_number=$controlNumberDetails->control_number;
//$control_number=94904;

$applicant_category=$controlNumberDetails->applicant_category_id>0?$controlNumberDetails->applicantCategory->applicant_category:"";

?>
      <div class="panel panel-info">
        <div class="panel-heading">
      
        </div>
        <div class="panel-body"> 
            <?php
// if(true){ //Application fee not yet paid
                 $status_pay="Application Fee NOT Paid";
                // $controlNumberDetails->receipt_number=737274;
             
  //echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-danger"> '.$status_pay.'</span></span><br><br>';
   if($control_number!=""&&$controlNumberDetails->receipt_number==""){
  echo "  <p class='alert alert-danger'>
      
      <strong>Your Payment control  Number is</strong>: {$control_number}<br>
    
          The Application Fee is <strong>TZS ".number_format($amount)."</strong> 
              <br/>
        <strong style='color:#fff'>After you have finished paying, wait for payment confirmation.
    </p> ";
    }
    if($control_number==""){
     echo "  <p class='alert alert-danger'>
      
        <strong style='color:#fff'>Please! Wait for payment control  Number.</strong>
    </p> ";    
        
    }
 
      if($control_number!=""&&$controlNumberDetails->receipt_number!=""){
                $status_pay="Application Fee Paid ";  
                  echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-success"> '.$status_pay.'</span></span><br><br>';
  echo "<p class='alert alert-success'>
      
      <strong>Congratulations! </strong>Your payment has been successfully received.Here are your payment details:<br>
    
         <strong>Payment Reference#: </strong>".$controlNumberDetails->receipt_number."<br>
		 <strong>Amount Paid: </strong>"." TZS ".number_format($amount)."/="."<br>
		 <strong>Mode of Payment: </strong>"."Payment Made by Mobile Phone Number ".$payerPhone."<br>
		 <strong>Date Payment was received: </strong>".$controlNumberDetails->date_receipt_received."<br>
		 <strong>Applicant Category: </strong>".$loanee_category." ".$applicant_category."<br><br>
		 <strong>You can now continue with the next steps of Application (Click My application).</strong>".
		 "</p> ";
                 }
?>
        </div>
      </div>