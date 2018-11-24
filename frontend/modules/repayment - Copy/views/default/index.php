<?php

use yii\helpers\Html;
//use frontend\modules\repayment\models\LoanSummary;

$this->title = "Home | iLMS";
$loggedin = Yii::$app->user->identity->user_id;
$employer2 = \frontend\modules\repayment\models\EmployerSearch::getEmployer($loggedin);
        $employerID = $employer2->employer_id;
        //check government employers if had stated salary source
$employerSalarySource = \frontend\modules\repayment\models\Employer::getEmployerSalarySource($employerID);
        //end check
		
		
?>
<?php 
//update VRF
frontend\modules\repayment\models\LoanSummary::updateVRFaccumulatedGeneral();
//END update VRF
//employer penalty
frontend\modules\repayment\models\EmployerPenaltyPayment::getPenaltyToEmployer();
//end employer penalty
?>
<style type="text/css">
    .btn.btn-app{
        min-width:250px;
        min-height:180px;
    }
	.welcome{
	   text-align:center;
	   font-size:30px;
	}
</style>
<div class="box box-info">
    <div class="box-body">
                <div class="welcome"><p>Welcome to HESLB Loan Repayment System.</p></div>
            </a>
			<?php 
			if($employerSalarySource !=0){
			?>
					<div class="alert alert-info alert-dismissible">
You are required to select the salary source before you proceed with other functions.
						<?= Html::a('Click here to select salary source', ['/repayment/employer/update-salarysource', 'id' => $employerID], ['class'=>'alert-link']) ?>

              </div>
					<?php } ?>
        </div>
    </div>
</div>  
