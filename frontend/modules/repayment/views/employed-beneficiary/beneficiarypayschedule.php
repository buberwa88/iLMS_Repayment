<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Active Loan Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
$loan_given_to=\frontend\modules\repayment\models\LoanRepaymentDetail::LOAN_GIVEN_TO_LOANEE;
?>
<script>
  function check_status() {
      //form-group field-user-verifycode
   document.getElementById("hidden").style.display = "none";
   document.getElementById("loader").style.display = "block";
    }
</script>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-body"> 
<div id="hidden">
<p>
        <?= Html::a('Get New Repayment Schedule', ['employed-beneficiary/newrepayment-schedule'], ['class' => 'btn btn-success','onclick'=>'return  check_status()']) ?>
        
    </p>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],			
           //'employed_beneficiary_id',
			[
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('viewLoanItemsSchedule',['model'=>$model]);
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
				/*
            [
                     'attribute' => 'employerName',
                        'label'=>"Employer",
                        'value' => function ($model) {
                            return $model->employer->employer_name;
                        },
            ],
			*/
			[
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],  
            [
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
            ],
            [
                     'attribute' => 'basic_salary',
                        'label'=>"Gross Salary",
						'hAlign' => 'right',
                        'format' => ['decimal', 2],
                        'value' => function ($model) {
							if($model->basic_salary > '0'){
                            return $model->basic_salary;
						}else{
							return '0';
						}
                        },
            ], 
        ],
    ]); ?>
	<?= Html::endForm();?> 
</div>	
<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center>
</div>
       </div>
</div>
