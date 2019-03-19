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
				return $data->firstname;
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
            ],
            [
                'label' => 'Middle Name',
                'value'=>call_user_func(function ($data){
				return $data->middlename;
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
				return $data->surname;
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
            ],
            [
                'label' => 'Sex',
                'value'=>call_user_func(function ($data){
					if($data->sex=='M'){
					return 'Male';	
					}else if($data->sex=='F'){
					return 'Female';	
					}else{
					return '';	
					}
				
            }, $model),
                'labelColOptions' => ['style' => 'width:20%'],
                'valueColOptions' => ['style' => 'width:30%'],
            ],
        ],
    ],
    [
        'columns' => [

            [
                'label' => 'f4index #',
                'value'=>call_user_func(function ($data){
				return $data->f4indexno.'.'.$data->form_four_completion_year;
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
