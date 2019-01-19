<?php
ini_set('memory_limit', '10000M');
set_time_limit(0);
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use backend\modules\report\models\Report;

$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;

$subtitalAcc=0;
$subtitalAccq=0;
$date=date("Y-m-d");
$resultsCheckExist=\backend\modules\repayment\models\LoanRepaymentDetail::beneficiaryRepaymentExistByDate($applicant_id, $date, $loan_given_to);
?>
<?php
if($resultsCheckExist){
$getDetails = \backend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT loan_repayment_detail.loan_repayment_id, loan_repayment_detail.applicant_id, loan_repayment_detail.loan_repayment_item_id, SUM(loan_repayment_detail.amount) AS amount,SUM(loan_repayment_detail.vrf_accumulated) AS vrf_accumulated,loan_repayment.receipt_date FROM loan_repayment_detail INNER JOIN loan_repayment ON loan_repayment.loan_repayment_id=loan_repayment_detail.loan_repayment_id 
WHERE loan_repayment_detail.loan_given_to=1 AND loan_repayment_detail.applicant_id='$applicant_id' GROUP BY loan_repayment_detail.loan_repayment_id")->all();
$sno=1;
?>
<br/><br/>
<table width='100%'>
    <tr><th style="text-align: left; ">Payment Date</th><th style="text-align: right; ">Repaid</th><th style="text-align: right; ">Laf Portion</th><th style="text-align: right; ">Penalty Portion</th><th style="text-align: right; ">Vrf Portion</th><th style="text-align: right; ">Principal Portion</th><th style="text-align: right; ">Total Vrf</th><th style="text-align: right; ">Vrf Applicable</th><th style="text-align: right; ">Outstanding Vrf</th><th style="text-align: right; ">Outstanding Principal</th></tr>
    <?php
    $amountDeduct=0;
    foreach ($getDetails AS $values){
		$loan_repayment_id=$values->loan_repayment_id;
        ?>
        <tr>
        <td style="text-align: left; "><?php echo date("d-m-Y",strtotime($values->receipt_date)); ?></td>
        <td style="text-align: right; "><?php echo number_format($values->amount,2); ?></td>
    <?php
        $loanItemDesc=\backend\modules\repayment\models\LoanRepaymentDetail::findBySql("SELECT loan_repayment_item.item_code, loan_repayment_detail.amount,loan_repayment_detail.vrf_accumulated FROM loan_repayment_detail INNER JOIN loan_repayment_item ON loan_repayment_item.loan_repayment_item_id=loan_repayment_detail.loan_repayment_item_id 
WHERE loan_repayment_detail.applicant_id='$applicant_id' AND loan_repayment_detail.loan_repayment_id='$loan_repayment_id'")->all();

        foreach ($loanItemDesc AS $itemValue) {

            //get items sub-query
            $sub_query_itemsFirst = \backend\modules\repayment\models\LoanRepaymentItem::findBySql("SELECT loan_repayment_item.item_code FROM loan_repayment_item WHERE loan_repayment_item.payable_order_list >0 ORDER BY payable_order_list ASC")->all();;
            foreach ($sub_query_itemsFirst AS $sub_query_items) {
                if (isset($sub_query_items['item_code']) && $itemValue->item_code == $sub_query_items['item_code']) {
                    ?>
                        <td style="text-align: right; "><?php echo number_format($itemValue->amount,2); ?></td>

                    <?php
                }
            }
        }
        ?>
    <td style="text-align: right; "><?php echo number_format(0); ?></td>
    <td style="text-align: right; "><?php echo number_format($values->vrf_accumulated,2); ?></td>
    <td style="text-align: right; "><?php echo number_format(0); ?></td>
    <td style="text-align: right; "><?php echo number_format(0); ?></td>
    </tr>
    <?php
    }
        }
    ?>
</table>

