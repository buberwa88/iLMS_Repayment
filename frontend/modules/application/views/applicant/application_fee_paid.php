<div style="width: 95%">
<?php
//Applicant Category
//if($modelUser->user_type_id == 2){
//    $category = 'Direct Applicant (Form Six) - Both O-Level and A-Level Certificates are from NECTA';
//} else if($modelUser->user_type_id == 3){
//    $category = 'Direct Applicant (Form Six) - Some or all of the Certificates are from Foreign Countries ';
//} else if($modelUser->user_type_id == 4){
//    $category = 'Applicant with Equivalent Qualification (Diploma or FTC)';
//} else {
//    die("Technical Error, please consult your system administrator");
//}
use yii\helpers\Html;
$category = \app\models\UserType::findOne($modelUser->user_type_id)->user_type_desc;

?>
      <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            
   <?php
  echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-success"> Payment Confirmed</span><br><br>';
  echo "  <p class = 'alert alert-success'>
       <strong>Congratulations!</strong>. Your payment has been successfully received. Here are your payment details: <br><br>
       
            <strong>Payment Reference#</strong>: {$modelRefNo->pref_no}<br><br>
            <strong>Amount Paid</strong>: TZS ". number_format($modelRefNo->amount_paid, 2)."/= <br><br>
            <strong>Mode of Payment</strong>: Payment made by Mobile Phone Number +{$modelRefNo->mobile_no}<br><br>
            
            <strong>Date Payment was Received</strong>: ".$modelRefNo->date_confirmed."<br><br>
            <strong>Applicant Category</strong>: {$category} <br><br><br>

            You can now continue with the next steps of Application.
    </p> "; 
  
 
 ?>
</div>
      </div>
</div>