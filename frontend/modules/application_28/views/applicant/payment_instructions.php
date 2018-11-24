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
      $('#pay-airtel').attr('style','display: none');
      $('#after-pay-instructions-id').attr('style','display: none');
      
      if(id == 2){
         $('#pay-mpesa').attr('style','display: block');
      }
      
      if(id == 3){
         $('#pay-tigopesa').attr('style','display: block');
      }
      
      if(id == 4){
         $('#pay-airtel').attr('style','display: block');
      }
      
      $('#after-pay-instructions-id').attr('style','display: block');
      
    }
 
</script>


<div style="width: 95%">
<?php
use yii\helpers\Html;
$this->title = 'Application Fee';
$this->params['breadcrumbs'][] = ['label'=>'My Application','url'=>['/application/default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;


//$this->context->layout = 'simple_layout_no_loading';

//$amount = 50000;
//$control_number = 108899333;
$controlNumberDetails=\backend\modules\application\models\Application::getControlNumber($user_id);
//$amount = 50000;
//$control_number = 108899333;
$amount=$controlNumberDetails->amount_paid;
$control_number=$controlNumberDetails->control_number;


?>
      <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body"> 
            <?php
 if(true){ //Application fee not yet paid
  echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-danger"> Application Fee NOT Paid</span></span><br><br>';
  echo "  <p class='alert alert-danger'>
      
      <strong>Your Payment Reference Number is</strong>: {$control_number}<br>
    
          The Application Fee is <strong>TZS ".number_format($amount)."</strong> 
    </p> ";
  
 } 
 
//echo \yii\helpers\Html::dropDownList('mode_of_payment', '', [1=>'---PLEASE SELECT MODE OF PAYMENT----',2=>'PAY USING M-PESA',3=>'PAY USING TIGO PESA',4=>'PAY USING AIRTEL MONEY'],['class'=>'form-control','onclick'=>'displayInstructions()','id'=>'mode-of-payment-id']);
echo \yii\helpers\Html::dropDownList('mode_of_payment', '', [1=>'---PLEASE SELECT MODE OF PAYMENT----',2=>'PAY USING M-PESA',3=>'PAY USING TIGO PESA'],['class'=>'form-control','onclick'=>'displayInstructions()','id'=>'mode-of-payment-id']);
 ?>

    <br>
    <div id="pay-mpesa" style="display: none">
        <strong> PAYING USING M-PESA </strong>
       <ol type="1">
           <li>Open your mpesa by dialling *150*00#</li>
           <li>Then chose 4 LIPA kwa M-Pesa</li>
           <li>Then chose 4 Weka namba ya kampuni</li>
           <li>Then Business number/Namba ya kampuni: 888999</li>
           <li> Enter   Reference number (Namba ya kumbukumbu)- Yours is (Ya kwako ni) <strong><?= $control_number ?></strong></li>
   </li>
           
           
       </ol>

    </div>
    
    <div id="pay-tigopesa" style="display: none">
        <strong>  PAYING USING TIGOPESA </strong>
        <ol type="1">
           <li>Open your Tigo-Pesa Number dialling *150*01#</li>
           <li>Then chose 4 LIPA Bili,PAY bill</li>
           <li>Then chose 3 Weka namba ya kampuni</li>
           <li>Then Business number/Namba ya kampuni: 888999</li>
           <li> Enter   Reference number (Namba ya kumbukumbu)- Yours is (Ya kwako ni) <strong><?= $control_number ?></strong></li>
          
       </ol>
    </div>
  
  
  <div id="pay-airtel" style="display: none">
      <strong>  PAYING USING AIRTEL MONEY </strong>
       <ol type="1">
           <li>Airtel Money Number dialling *150*60#</li>
           <li>Then chose 5 Lipia bili</li>
           <li>Then chose 4 Weka namba ya kampuni</li>
           <li>Then Business number/Namba ya kampuni ni: 888999</li>
           <li> Enter   Reference number (Namba ya kumbukumbu)- Yours is (Ya kwako ni) <strong><?= $control_number ?></strong></li>
          
       </ol>
  </div>
    <div id="after-pay-instructions-id" style="display: none">
    <strong style="color:#3788bd ">After you have finished paying, wait for payment confirmation. You will automatically be redirected to another page once the payment is confirmed</strong>
</div>
     <div class="col-lg-12">
 
  <?= Html::a('Go Next Step>>', ['application/study-view'], ['class' => 'pull-right']) ?>
 
            </div>
</div>
      </div>
</div>


