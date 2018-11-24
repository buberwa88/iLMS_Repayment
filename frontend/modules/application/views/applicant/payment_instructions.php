<script>
    
    window.addEventListener("DOMContentLoaded", function() {
        IsFeePaid();
    }, false);

    function IsFeePaid(){
     
        $.ajax({
        url: '<?= yii\helpers\Url::to(['/applicants/check-payment'], true) ?>',
        type: 'get',
        dataType: 'JSON',
        success: function(response){
          var status =  response.status;
           if(status == 'payment_not_confirmed'){
               setTimeout('IsFeePaid()',20000);
              
           } else {
               document.location.href = '<?= yii\helpers\Url::to(['/applicants/pay-application-fee'], true) ?>';
           }
        }
    }); 
    }
    function displayInstructions(){
      var id = $('#mode-of-payment-id').val();
      $('#pay-mpesa').attr('style','display: none');
      $('#pay-tigopesa').attr('style','display: none');
      $('#pay-airtelmoney').attr('style','display: none');
      $('#pay-crdbbank').attr('style','display: none');
      $('#pay-nmbbank').attr('style','display: none');
      $('#after-pay-instructions-id').attr('style','display: none');
      
      if(id == 2){
         $('#pay-mpesa').attr('style','display: block');
      }
      
      if(id == 3){
         $('#pay-tigopesa').attr('style','display: block');
      }
      
      if(id == 4){
         $('#pay-airtelmoney').attr('style','display: block');
      }
        if(id == 5){
         $('#pay-nmbbank').attr('style','display: block');
      }
        if(id == 6){
         $('#pay-crdbbank').attr('style','display: block');
      }
      $('#after-pay-instructions-id').attr('style','display: block');
      
    }
 
</script>

<?php 
//$amount = 50000;
//$control_number = 108899333;
$controlNumberDetails=\backend\modules\application\models\Application::getControlNumber($user_id);
 
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
$applicant_category=$controlNumberDetails->applicant_category_id>0?$controlNumberDetails->applicantCategory->applicant_category:"";
$label_blank=$controlNumberDetails->loanee_category." ".$applicant_category;
?>
      <div class="panel panel-info">
        <div class="panel-heading">
       Step 1 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$label_blank?></label>
        </div>
        <div class="panel-body"> 
            <?php
// if(true){ //Application fee not yet paid
                 $status_pay="Application Fee NOT Paid";
             
  //echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-danger"> '.$status_pay.'</span></span><br><br>';
//   if($control_number!=""&&$controlNumberDetails->receipt_number==""){
//  echo "  <p class='alert alert-danger'>
//      
//      <strong>Your Payment control  Number is</strong>: {$control_number}<br>
//    
//          The Application Fee is <strong>TZS ".number_format($amount)."</strong> 
//              <br/>
//        <strong style='color:#fff'>After you have finished paying, wait for payment confirmation.
//    </p> ";
//    }
//    if($control_number==""){
//     echo "  <p class='alert alert-danger'>
//      
//        <strong style='color:#fff'>Please! Wait for payment control  Number.</strong>
//    </p> ";    
//        
//    }
  
   //if($control_number!=""&&$controlNumberDetails->receipt_number==""){
//echo \yii\helpers\Html::dropDownList('mode_of_payment', '', [1=>'---PLEASE SELECT MODE OF PAYMENT----',2=>'PAY USING M-PESA',3=>'PAY USING TIGO PESA',4=>'PAY USING AIRTEL MONEY'],['class'=>'form-control','onclick'=>'displayInstructions()','id'=>'mode-of-payment-id']);
echo \yii\helpers\Html::dropDownList('mode_of_payment', '', [1=>'---PLEASE SELECT MODE OF PAYMENT----',2=>'PAY USING M-PESA',3=>'PAY USING TIGO PESA',4=>'PAYING USING AIRTEL MONEY',5=>'PAYING USING NMB BANK',6=>'PAYING USING CRDB BANK'],['class'=>'form-control','onclick'=>'displayInstructions()','id'=>'mode-of-payment-id']);
  // }
//      if($control_number!=""&&$controlNumberDetails->receipt_number!=""){
//                $status_pay="Application Fee Paid ";  
//                  echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-success"> '.$status_pay.'</span></span><br><br>';
//  echo "  <p class='alert alert-success'>
//      
//      <strong>Congratulations! </strong>Your payment has been successfully received.Here are your payment details:<br>
//    
//         <strong>Payment Reference#: </strong>".$controlNumberDetails->receipt_number."<br>
//		 <strong>Amount Paid: </strong>"." TZS ".number_format($amount)."/="."<br>
//		 <strong>Mode of Payment: </strong>"."Payment Made by Mobile Phone Number ".$payerPhone."<br>
//		 <strong>Date Payment was received: </strong>".$controlNumberDetails->date_receipt_received."<br>
//		 <strong>Applicant Category: </strong>".$loanee_category." ".$applicant_category."<br><br>
//		 <strong>You can now continue with the next steps of Application (Click My application).</strong>".
//		 "</p> ";
//                 }
?>

  <br>
 <div id="pay-mpesa" style="display:none;">
   <strong>PAYING USING M-PESA</strong>
   <ol>
	   <li>
			Bonyeza <strong>*150*00#</strong> kwenda kwenye menyu ya <strong>M-PESA</strong>.
	   </li>
	   <li>Chagua <strong>namba 4</strong>(LIPA kwa M-PESA).</li>
	   <li>Chagua <strong>namba 4</strong>(Weka namba ya kampuni).</li>
	   <li>Tafadhali weka namba ya kampuni ambayo ni <strong>888999</strong>.</li>
	   <li>
			Weka namba ya kumbukumbu ya malipo ambayo ni <strong>Control Number( <?php echo $control_number; ?> )</strong>.
	   </li>
	   <li>Weka kiasi ambacho ni <strong>TZS 30,000/=</strong>.</li>
	   <li>Weka <strong>namba yako ya siri</strong>.</li>
	   <li>Bonyeza 1 kuthibitisha au 2 kubatilisha.</li>
   </ol>
</div>
<div id="pay-tigopesa" style="display:none;">
   <strong>PAYING USING TIGOPESA</strong>
   <ol>
	   <li>
			Bonyeza <strong>*150*01#</strong> kwenda kwenye menyu ya <strong>TigoPesa</strong>.
	   </li>
	   <li>Chagua <strong>namba 4</strong>(Kulipia Bili).</li>
	   <li>Chagua <strong>namba 3</strong>(Ingiza namba ya kampuni).</li>
	   <li>Ingiza namba ya kampuni ambayo ni <strong>888999</strong>.</li>
	   <li>
			Weka namba ya kumbukumbu ambayo ni <strong>Control Number( <?php echo $control_number; ?> )</strong>.
	   </li>
	   <li>Ingiza kiasi ambacho ni <strong>TZS 30,000/=</strong>.</li>
	   <li>Ingiza <strong>namba yako ya siri</strong>.</li>
   </ol>
</div>
<div id="pay-airtelmoney" style="display:none;">
   <strong>PAYING USING AIRTEL MONEY</strong>
   <ol>
	   <li>
			Bonyeza <strong>*150*60#</strong> kwenda kwenye menyu ya <strong>AIRTEL MONEY</strong>.
	   </li>
	   <li>Chagua <strong>namba 5</strong>(Lipia Bili).</li>
	   <li>Chagua <strong>namba 4</strong>(Weka namba ya kampuni).</li>
	   <li>Andika namba ya biashara ambayo ni <strong>888999</strong>.</li>
	   <li>Ingiza kiasi cha pesa ambacho ni <strong>TZS 30,000/=</strong>.</li>
	   <li>
			Ingiza namba ya kumbukumbu ambayo ni <strong>Control Number( <?php echo $control_number; ?> )</strong>.
	   </li>
	   <li>Ingiza <strong>namba yako ya siri</strong>.</li>
   </ol>
</div>
<div id="pay-nmbbank" style="display:none;">
   <strong>PAYING USING NMB BANK</strong>
   <ol>
	   <li>
			Chukua <strong>Control Number( <?php echo $control_number; ?> )</strong>.
	   </li>
	   <li>
			Nenda na <strong>Control Number</strong> kwenye <strong>tawi lolote la banki ya NMB</strong>.
	   </li>
	   <li>Jaza fomu ya <strong>ONLINE BILLS PAYMENT SLIP</strong>.</li>
	   <li>Andika Control Number kwenye kisanduku kilichoandikwa <strong>Payment Reference Number(PRN)</strong>.</li>
	   <li>Andika kiasi cha <strong>TZS 30,000/=</strong> kwa tarakimu na maneno.</li>
	   <li>Jaza sehemu zingine za fomu kama inavyoelekezwa kwenye fomu.</li>
	   <li>Peleka fomu kwenye <strong>dirisha la malipo</strong>.</li>
	   <li>Toa kiasi cha <strong>TZS 30,000/=</strong>.</li>
   </ol>
</div>
<div id="pay-crdbbank" style="display:none;">
   <strong>PAYING USING CRDB BANK</strong>
   <ol>
	   <li>
			Chukua <strong>Control Number( <?php echo $control_number; ?> )</strong>.
	   </li>
	   <li>
			Nenda na <strong>Control Number</strong> kwenye <strong>tawi lolote la banki ya CRDB</strong>.
	   </li>
	   <li>Onyesha Control Number katika <strong>dirisha la malipo</strong>.</li>
	   <li>Toa kiasi cha <strong>TZS 30,000/=</strong>.</li>
	   <li>Chukua <strong>risiti ya malipo</strong> hayo.</li>
   </ol>
</div>

<div class="col-lg-12">
           <iframe src="<?= yii\helpers\Url::to(['/application/default/payment-status']);?>" width="100%" height="300px" style="border: 0"></iframe>
   <br>
 <?php
    if($control_number!=""&&$controlNumberDetails->receipt_number!=""){ ?>
  <?= Html::a('Next Step>>', ['application/study-view'], ['class' => 'pull-right']) ?>
 <?php 
    } ?>
            </div>
</div>
      </div>
</div>
