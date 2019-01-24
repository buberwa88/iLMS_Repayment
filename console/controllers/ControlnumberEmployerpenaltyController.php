<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\filters\VerbFilter;
date_default_timezone_set('Africa/Nairobi');
/**
 * ApplicantController implements the CRUD actions for Applicant model.
 */
class ControlnumberEmployerpenaltyController extends Controller {


    
    public function actionIndex($control_number, $billNumber,$date_control_received)
    {
		//echo "tele";
		
if($control_number !='' && $billNumber !='' && $date_control_received !='') {
            \frontend\modules\repayment\models\EmployerPenaltyPayment::updateControlngepgrealy($control_number,$billNumber,$date_control_received);
        }
		
        
    }
}
