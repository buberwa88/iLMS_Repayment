<?php

use yii\helpers\Html;
//use frontend\modules\repayment\models\LoanSummary;

$this->title = "Home | iLMS";
?>
<?php 
//update VRF
frontend\modules\repayment\models\LoanSummary::updateVRFaccumulatedGeneral();
//END update VRF
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
                <div class="welcome"><p>Welcome to Integrated Loan Management System.</p></div>
            </a>
        </div>
    </div>
</div>  
