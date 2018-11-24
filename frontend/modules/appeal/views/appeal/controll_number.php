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

            <p class="alert alert-info">
                <strong>Please Wait For Controll...</strong> <br>
                
                Refresh after few minutes
            </p>
        </div>
    </div>
</div>

