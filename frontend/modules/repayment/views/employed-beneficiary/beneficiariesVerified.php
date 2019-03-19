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
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-body"> 
						<?php 
$countEmployees=\frontend\modules\repayment\models\EmployedBeneficiary::getCountBeneficiaries($employerID);
if($countEmployees > 0){
						?>
<?= Html::a('Upload(Update) Salary', ['upload-salaries'], ['class' => 'btn btn-primary']) ?>
<div class="text-right">
                <?php 
echo Html::a('Export Excel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp', Url::toRoute(['export-beneficiaries']));
                ?>
                </div>
<?php } ?>				
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
                  return $this->render('viewLoanItems',['model'=>$model]);  
				  //return $this->render('viewLoanStatement',['model'=>$model]);
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
            [
                'attribute' => 'totalLoan',
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) use($loan_given_to) {
					$date=date("Y-m-d");
                return \backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($model->applicant_id,$date,$loan_given_to);
        },
            ],
			[
                'attribute' => 'outstanding',
				'label'=>'Outstanding',
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) use($loan_given_to) {
					$date=date("Y-m-d");
                return \frontend\modules\repayment\models\LoanRepaymentDetail::getOutstandingOriginalLoan($model->applicant_id,$date,$loan_given_to);
        },
            ], 
        [
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Actions',
          'headerOptions' => ['style' => 'color:#337ab7'],
          'template' => '{view}{update}',
          'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                ]);
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'update'),
                ]);
            },
          ],
          'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/employed-beneficiary/view-beneficiary&id='.$model->employed_beneficiary_id;
                return $url;
            }

            if ($action === 'update') {
                $url ='index.php?r=repayment/employed-beneficiary/update-beneficiary&id='.$model->employed_beneficiary_id;
                return $url;
            }
          }
          ],
         [
        'label'=>'',
         'value'=>function($model){
                  return Html::a("Deactivate", ['/repayment/employed-beneficiary/deactivate-beneficiary','id'=>$model->employed_beneficiary_id], ['class'=>'label label-warning']);
         },
        'format'=>'raw',
        ],
        ],
    ]); ?>
	<?= Html::endForm();?> 
</div>
       </div>
</div>
