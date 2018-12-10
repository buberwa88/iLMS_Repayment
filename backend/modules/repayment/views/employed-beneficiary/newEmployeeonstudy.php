<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'New Beneficiaries ONSTUDY';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('view',['model'=>$model]); 
                  //return $this->render('../../../../../frontend/modules/repayment/views/employed-beneficiary/viewLoanStatement',['model'=>$model]);				  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
            [
                     'attribute' => 'employerName',
                        'label'=>"Employer",
                        'value' => function ($model) {
                            return $model->employer->employer_name;
                        },
            ],
			[
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
			/*
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
			*/
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
                            return $model->f4indexno;
                        },
            ],	
			
            [
                'attribute' => 'totalLoan',
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
					$date=date("Y-m-d");
                return backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($model->applicant_id,$date);
        },
            ],
            [
                'attribute' => 'basic_salary',
                //'label' => "Basic Salary",
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
                return $model->basic_salary;
        },
            ],
                [
                     'attribute' => 'mult_employed',
                        'label'=>"Employment Status",
                        'format' => 'raw',
                        'value' => function ($model) {
            
                        if($model->mult_employed ==1){
                                     return Html::a("Double Employed", ['/repayment/employed-beneficiary/mult-employed','id'=>$model->applicant_id]);
                                    } else {
                                        return "Single Employed";
                                    }
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[0=>"Single Employed",1=>'Double Employed'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ], 
                                
                        ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template'=>'{update}',
                'buttons' => [
            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'update'),
                ]);
            },
          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'update') {
                $url ='index.php?r=repayment/employed-beneficiary/update-employeeonstudy&id='.$model->employed_beneficiary_id;
                return $url;
            }
          }            
            ],
        ],
    ]); ?>
</div>
       </div>
</div>
