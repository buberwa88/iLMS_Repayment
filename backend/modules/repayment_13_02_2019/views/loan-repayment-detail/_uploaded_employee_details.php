<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;

$loan_given_to = \frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
    <h4><b>Uploaded Details</b></h4>
<?php

$attributes = [
    [
        'columns' => [

            [
                'label' => 'First Name',
                'value'=>call_user_func(function ($data){
				return \frontend\modules\repayment\models\EmployedBeneficiary::getEmployeeByCheckNumberandEmployer_id($data->check_number,$data->employer_id)->firstname;
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
            ],
            [
                'label' => 'Middle Name',
                'value'=>call_user_func(function ($data){
				return \frontend\modules\repayment\models\EmployedBeneficiary::getEmployeeByCheckNumberandEmployer_id($data->check_number,$data->employer_id)->middlename;
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
            ],
        ],
    ],
    [
        'columns' => [

            [
                'label' => 'Last Name',
                'value'=>call_user_func(function ($data){
				return \frontend\modules\repayment\models\EmployedBeneficiary::getEmployeeByCheckNumberandEmployer_id($data->check_number,$data->employer_id)->surname;
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
            ],
        ],
    ],
];
echo DetailView::widget([
    'model' => $model,
    'condensed' => true,
    'hover' => true,
    'mode' => DetailView::MODE_VIEW,
    'attributes' => $attributes,
]);
