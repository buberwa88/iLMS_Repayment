<div style="position: relative;float: left;margin: 0%;">

    <span style="position: relative;float: left;margin: 1%;padding: 0;">
        <?php
///recaluate loan
        echo \yii\bootstrap\Html::a('Re-Calculate Loan', ['/repayment/loan-beneficiary/recalculate-loan', 'id' => $model->application_id], ['class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to Re-Calculate loan for this Beneficiary?',
                'method' => 'post',
            ],]
        );
        ?>
    </span>
    <span style="position: relative;float: left;margin: 1%">
        <?php
///Confirm Loan letter
        if (\common\models\LoanBeneficiary::getLoanConfirmationStatusByApplicantID($model->applicant_id) != \common\models\LoanBeneficiary::LOAN_STATEMENT_CONFIRMED) {
            echo \yii\bootstrap\Html::a('Confirm Loan Amount', ['/repayment/loan-beneficiary/confirm-statement', 'id' => $model->application_id], ['class' => 'btn btn-small btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to Confirm Total Amount Loan for this Beneficiary? NOTE: Once Confirmed  the benefiary Statement Will be a verified Statement',
                    'method' => 'post',
                ],]
            );
        }
        ?>
    </span>
    <span style="position: relative;float: left;margin: 1%">

        <?php
///issue liquidation letter
        if (\common\models\LoanBeneficiary::getLiqudationStatusByApplicantID($model->applicant_id) != \common\models\LoanBeneficiary::LOAN_STATEMENT_CONFIRMED) {
            echo \yii\bootstrap\Html::a('Offer/Send Liquidation Letter', ['/repayment/loan-beneficiary/issue-riquidation', 'id' => $model->application_id], ['class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Are you sure you want to Send/Offer a Liquidation Letter for this Beneficiary?',
                    'method' => 'post',
                ],]
            );
        }
        ?>
    </span>
</div>

