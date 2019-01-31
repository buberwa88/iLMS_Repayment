<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\filters\VerbFilter;
date_default_timezone_set('Africa/Nairobi');
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class CancelBillrepaymentController extends Controller {


    
    public function actionIndex($bill_reference_table,$billNumber,$cancelled_by,$cancelled_date,$cancelled_reason,$bill_reference_table_id,$primary_keycolumn)
    {
	if($bill_reference_table !='' && $billNumber !='' && $cancelled_by !='' && $cancelled_date !='' && $cancelled_reason !='' && $bill_reference_table_id !='' && $primary_keycolumn !='') {
            \frontend\modules\repayment\models\LoanRepayment::cancelBillgeneral($bill_reference_table,$billNumber,$cancelled_by,$cancelled_date,$cancelled_reason,$bill_reference_table_id,$primary_keycolumn);
        }   
    }
}
