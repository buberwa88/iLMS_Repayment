<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployedBeneficiary */
$applicantID1=$model->applicant_id;
if($applicantID1 !=''){
$applicantID=$applicantID1;    
}else{
  $f4indexno=$model->f4indexno;  
  $employerId=$model->employer_id;
  $employeeId=$model->employee_id;
}
if($applicantID1 !=''){
$employee_current_name1=$model->getEmployeeUserId($applicantID);
$employee_current_name=$employee_current_name1->current_name;
$employee_NIN=$employee_current_name1->NID;
$user_id=$employee_current_name1->user_id;
$phoneValue=$model->getUserPhone($user_id);
$phoneNumbers=$phoneValue->phone_number;

$employee_firstname=$model->applicant->user->firstname." ".$model->applicant->user->middlename." ".$model->applicant->user->surname;
$employee_current_name=$model->applicant->current_name;
}else{
$employee_current_name2=$model->checkEmployeeExistsNonApplicant($f4indexno,$employerId,$employeeId);
$employee_current_name=$employee_current_name2->firstname;
$phoneNumbers=$employee_current_name2->phone_number;
$employee_NIN=$employee_current_name2->NID;
$employee_firstname=$employee_current_name2->firstname;
}

$employee_name=$employee_current_name !='' ? $employee_current_name:$employee_firstname;
$this->title = 'Update Employee: ' . $employee_name;
$this->params['breadcrumbs'][] = ['label' => 'Un-verified employees', 'url' => ['un-verified-uploaded-employees']];
$this->params['breadcrumbs'][] = ['label' => $model->employed_beneficiary_id, 'url' => ['view', 'id' => $model->employed_beneficiary_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employed-beneficiary-update">
<div class="panel panel-info">
        <div class="panel-heading">

        </div>
        <div class="panel-body">

    <?= $this->render('_formUpdateEmployee', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
