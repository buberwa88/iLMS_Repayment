<?php
use backend\modules\repayment\models\LoanNonBeneficiary;
use common\models\LoanBeneficiary;
?>
<?php
$has_repayment = \backend\modules\repayment\models\LoanRepaymentDetail::beneficiaryRepaymentExistByDate($model->applicant_id, date('Y-m-d', time()), \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE);
?>
<div style="position: relative;float: left;margin: 0%;">

    <span style="position: relative;float: left;margin: 1%;padding: 0;">
        <?php
///recaluate loan
        if ($has_repayment) {
            echo \yii\bootstrap\Html::a('Re-Calculate Loan', ['/repayment/loan-beneficiary/recalculate-loan', 'id' => $model->applicant_id], ['class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to Re-Calculate loan for this Beneficiary?',
                    'method' => 'post',
                    'visible' => Yii::$app->user->can('role')
                ],]
            );
        }
        ?>
    </span>
    <span style="position: relative;float: left;margin: 1%">
        <?php
        if (!LoanNonBeneficiary::hasDisbursement($model->applicant_id) && !LoanNonBeneficiary::isNonBeneficiary($model->applicant_id) && LoanBeneficiary::getLoanConfirmationStatusByApplicantID($model->applicant_id) != LoanBeneficiary::LOAN_STATEMENT_CONFIRMED) {
            echo \yii\bootstrap\Html::a('Confirm Loan Amount', ['/repayment/loan-beneficiary/confirm-statement', 'id' => $model->applicant_id], ['class' => 'btn btn-small btn-warning',
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
///issue liquidation letter only if ahs paid and completed loan
        if ($has_repayment && backend\modules\repayment\models\Loan::hasLoan($model->applicant_id) && !backend\modules\repayment\models\Loan::hasUnCompletedLoan($model->applicant_id) && \common\models\LoanBeneficiary::getLiqudationStatusByApplicantID($model->applicant_id) != \common\models\LoanBeneficiary::LOAN_STATEMENT_CONFIRMED) {
            echo \yii\bootstrap\Html::a('Offer/Send Liquidation Letter', ['/repayment/loan-beneficiary/issue-riquidation', 'id' => $model->applicant_id], ['class' => 'btn btn-success',
                'data' => [
                    'confirm' => 'Are you sure you want to Send/Offer a Liquidation Letter for this Beneficiary?',
                    'method' => 'post',
                ],]
            );
        }
        ?>
    </span>
    <span style="position: relative;float: left;margin: 1%">
        <?php
///Confirm Non befeneficary liquidation letter only if ahs paid and completed loan
        if (!LoanNonBeneficiary::hasDisbursement($model->applicant_id) && !LoanNonBeneficiary::isNonBeneficiary($model->applicant_id)) {
            echo \yii\bootstrap\Html::a('Confirm Non-Beneficiary', ['/repayment/loan-beneficiary/confirm-nonbeneficiary', 'id' => $model->applicant_id], ['class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to Confirm Non-Beneficiary for this Applicant?',
                    'method' => 'post',
                ],]
            );
        }
        ?>
    </span>

    <span style="position: relative;float: left;margin: 1%">
        <?php
///Confirm Non befeneficary liquidation letter only if ahs paid and completed loan
        if (TRUE) {
            echo \yii\bootstrap\Html::a('Edit Beneficiary', ['/repayment/loan-beneficiary/edit', 'id' => $model->applicant_id], ['class' => 'btn btn-default',
                'data' => [
                    'confirm' => 'Are you sure you want to Confirm Non-Beneficiary for this Applicant?',
                    'method' => 'post',
                ],]
            );
        }
        ?>
    </span>
</div>
