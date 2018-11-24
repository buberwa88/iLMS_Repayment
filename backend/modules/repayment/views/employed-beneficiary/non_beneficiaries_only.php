<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-non-beneficiary-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModelNonBenef,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer.employer_name',
			[
                     'attribute' => 'employerName',
                        'label'=>"Employer",
                        //'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->employer->employer_name;
                        },
            ],
			[
                     'attribute' => 'firstname',
                        'label'=>"Full Name",
                        //'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->firstname;
                        },
            ],
			/*
			[
                     'attribute' => 'firstname',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->firstname;
                        },
            ],
		    [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->middlename;
                        },
            ],
		    [
                     'attribute' => 'surname',
                        'label'=>"Surname",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],
			*/
			[
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        //'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->f4indexno;
                        },
            ],
            [
                     'attribute' => 'basic_salary',
                        'label'=>"Basic Salary(TZS)",
                        'hAlign' => 'right',
                        'width' => '200px',
						 'format'=>['decimal', 2],
                        'value' => function ($model) {
                            return $model->basic_salary;
                        },
						'filter'=>'',
            ],
					
                    [
            'attribute'=>'loan_summary_id',
            'header'=>'Status',
            'filter' => '',
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->applicant_id == '')
                {
                    return '<p class="btn green"; style="color:red;">Non-Beneficiary</p>';
                }
                else
                {   
                    return '<p class="btn green"; style="color:green;">Beneficiary</p>';
                }
            },
			
        ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
		'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode('Employed Non-Beneficiaries') . ' </h3>',
            'type' => 'info',
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['all-beneficiaries'], ['class' => 'btn btn-info']),
            'showFooter' => true
        ],
    ]); ?>
</div>