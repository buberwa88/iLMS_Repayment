<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\ApplicantQuestion;
use frontend\modules\application\models\Education;
use frontend\modules\application\models\ApplicantAssociate;
use frontend\modules\application\models\Application;
use kartik\mpdf\Pdf;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */
                        

$this->title ="Appeal Payment";
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<style>
    img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 150px;
}



.center {
    margin: auto;
    width: 50%;
    padding: 10px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
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

<div class="application-view">
    <div class="panel panel-info">
        <div class="panel-heading">
           <?= Html::encode($this->title) ?>
        </div>

        <div class="panel-body">

            <?php
                if(true){ //Application fee not yet paid
                    echo '<span class="label label-primary">Status</span>:&nbsp;<span class="label label-danger"> Appeal Fee Not Received</span></span><br><br>';
                    echo "  <p class='alert alert-info'>
                    
                    <strong>Your Payment Reference Number is</strong>: {$appeal->control_number}<br>
                    
                        The Application Fee is <strong>TZS ".number_format(45000)."</strong> 
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
                    <li> Enter   Reference number (Namba ya kumbukumbu)- Yours is (Ya kwako ni) <strong><?= $appeal->control_number ?></strong></li>
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
                <li> Enter   Reference number (Namba ya kumbukumbu)- Yours is (Ya kwako ni) <strong><?= $appeal->control_number ?></strong></li>            
                </ol>
            </div>


            <div id="pay-airtel" style="display: none">
                <strong>  PAYING USING AIRTEL MONEY </strong>
                <ol type="1">
                    <li>Airtel Money Number dialling *150*60#</li>
                    <li>Then chose 5 Lipia bili</li>
                    <li>Then chose 4 Weka namba ya kampuni</li>
                    <li>Then Business number/Namba ya kampuni ni: 888999</li>
                    <li> Enter   Reference number (Namba ya kumbukumbu)- Yours is (Ya kwako ni) <strong><?= $appeal->control_number ?></strong></li>
                    
                </ol>
            </div>

            <div id="after-pay-instructions-id" style="display: none">
                <strong style="color:#3788bd ">After you have finished paying, wait for payment confirmation. You will automatically be redirected to another page once the payment is confirmed</strong>
            </div>

       
        </div>
    </div>


