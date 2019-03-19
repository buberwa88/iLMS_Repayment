<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verify non-applicants by providing the correct Form IV Index Number';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
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
                            return $model->firstname;
                        },
            ],
			/*
            [
                     'attribute' => 'middlename',
                        'label'=>"Middle Name",
                        'value' => function ($model) {
                            return $model->middlename;
                        },
            ],
			*/
		    [
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        'value' => function ($model) {
                            return $model->surname;
                        },
            ],  
            [
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        'value' => function ($model) {
                            return $model->f4indexno.'.'.$model->form_four_completion_year;
                        },
            ],
            [
                'attribute' => 'form_four_completion_year',
                'label'=>"Completion Year",
                'value' => function ($model) {
                    return $model->form_four_completion_year;
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
            'attribute'=>'loan_summary_id',
            'header'=>'Status',
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
            ['class' => 'yii\grid\ActionColumn',
			'template'=>'{update}{delete}',
			],			
                               
        ],
    ]); ?>
</div>
       </div>
</div>
