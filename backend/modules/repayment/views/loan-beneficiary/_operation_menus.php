<?php

///recaluate loan
echo \yii\bootstrap\Html::a('Re-Calculate Beneficiary Loan', ['/repayment/loan-beneficiary/recalculate-loan', 'id' => $model->application_id], ['class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'Are you sure you want to Re-Calculate loan for this Beneficiary?',
        'method' => 'post',
    ],]
);
?>
<?php

///Confirm Loan letter
echo \yii\bootstrap\Html::a('Confirm Beneficiary Loan', ['/repayment/loan-beneficiary/confirm-statement', 'id' => $model->application_id], ['class' => 'btn btn-small btn-warning',
    'data' => [
        'confirm' => 'Are you sure you want to Confirm Total Amount Loan for this Beneficiary? NOTE: Once Confirmed  the benefiary Statement Will be a verified Statement',
        'method' => 'post',
    ],]
);
?>

<?php

///issue liquidation letter
echo \yii\bootstrap\Html::a('Offer/Send Liquidation Letter', ['/repayment/loan-beneficiary/issue-riquidation', 'id' => $model->application_id], ['class' => 'btn btn-success',
    'data' => [
        'confirm' => 'Are you sure you want to Send/Offer a Liquidation Letter for this Beneficiary?',
        'method' => 'post',
    ],]
);
?>

