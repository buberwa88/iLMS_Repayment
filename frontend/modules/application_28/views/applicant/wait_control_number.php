<script>
    
    window.addEventListener("DOMContentLoaded", function() {
        CheckPaymentRefno();
    }, false);

    function CheckPaymentRefno(){
      
        $.ajax({
        url: '<?= yii\helpers\Url::to(['/applicants/check-prefno'], true) ?>',
        type: 'get',
        dataType: 'JSON',
        success: function(response){
          var status =  response.status;
       
           if(status == 'reference_not_received'){
               setTimeout('CheckPaymentRefno()',20000);
               
           } else {
               document.location.href = '<?= yii\helpers\Url::to(['/applicants/pay-application-fee'], true) ?>';
           }
        }
    }); 
    }
    
</script>
<?php //$this->context->layout = 'simple_layout_no_loading'; ?>
<p class="alert alert-success"><strong>Please wait for your Reference number. </strong> You should be able to get your reference number within 30 minutes. If you unable to receive the reference number within 30 minutes we advice you to logout and check after 24hours.</p>