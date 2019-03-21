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
$controlNumberSMS="Please use the below control number for payment,select the mode of payment for instructions.Thanks!";
$waitingControlNumber="Waiting Control Number!";
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanRepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pay Bill';
$this->params['breadcrumbs'][] = $this->title;

            $results1=$model->getLoanRepayment($model->loan_repayment_id);
            $control_number=$results1->control_number;
            $totalAmount=number_format($results1->amount,2);
?>
<div class="loan-repayment-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                            <?php
                            if($results1->control_number !=''){ ?>
                                <div class="alert alert-info alert-dismissible" id="labelshow">
                                    <h4 class="nonbeneficiarylabel" id="nonbeneficiarylabel"><i class="icon fa fa-info"></i><?php echo "<em>".$controlNumberSMS."</em>";?></h4>
                                </div>
                            <?php }else{ ?>

                                <div class="alert alert-warning alert-dismissible" id="labelshow">
                                    <h4 class="nonbeneficiarylabel" id="nonbeneficiarylabel"><i class="icon fa fa-info"></i><?php echo "<em>".$waitingControlNumber."</em>";?></h4>
                                </div>
                            <?php } ?>
            <?= $this->render('_formPaymentConfirmedBeneficiary', [
                'model' => $model
                ])            
                    ?>
                            <?php
                            if($results1->control_number !='') {
                                echo \yii\helpers\Html::dropDownList('mode_of_payment', '', [1 => '---PLEASE SELECT MODE OF PAYMENT----', 2 => 'PAY USING M-PESA', 3 => 'PAY USING TIGO PESA', 4 => 'PAYING USING AIRTEL MONEY', 5 => 'PAYING USING NMB BANK', 6 => 'PAYING USING CRDB BANK'], ['class' => 'form-control', 'onclick' => 'displayInstructions()', 'id' => 'mode-of-payment-id']);
                            }
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
                                    <li>Weka kiasi ambacho ni <strong>TZS <?php echo " ".$totalAmount; ?>/=</strong>.</li>
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
                                    <li>Ingiza kiasi ambacho ni <strong>TZS <?php echo " ".$totalAmount; ?>/=</strong>.</li>
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
                                    <li>Ingiza kiasi cha pesa ambacho ni <strong>TZS <?php echo " ".$totalAmount; ?>/=</strong>.</li>
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
                                    <li>Andika kiasi cha <strong>TZS <?php echo " ".$totalAmount; ?>/=</strong> kwa tarakimu na maneno.</li>
                                    <li>Jaza sehemu zingine za fomu kama inavyoelekezwa kwenye fomu.</li>
                                    <li>Peleka fomu kwenye <strong>dirisha la malipo</strong>.</li>
                                    <li>Toa kiasi cha <strong>TZS <?php echo " ".$totalAmount; ?>/=</strong>.</li>
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
                                    <li>Toa kiasi cha <strong>TZS <?php echo " ".$totalAmount; ?>/=</strong>.</li>
                                    <li>Chukua <strong>risiti ya malipo</strong> hayo.</li>
                                </ol>
                            </div>
</div>
       </div>
</div>
