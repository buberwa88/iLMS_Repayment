<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\filters\VerbFilter;
date_default_timezone_set('Africa/Nairobi');
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class PaymentRepaymentController extends Controller {


    
    public function actionIndex($control_number,$paid_amount,$date_receipt_received,$transaction_date,$receipt_number)
    {
	if($control_number !='' && $paid_amount !='' && $date_receipt_received !='' && $transaction_date !='' && $receipt_number !='') {
		//echo "tele";exit;
            \frontend\modules\repayment\models\LoanRepayment::updatePaymentAfterGePGconfirmPaymentDonelive($control_number,$paid_amount,$date_receipt_received,$transaction_date,$receipt_number);
        }   
    }
}
