<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use frontend\modules\repayment\models\EmployerSearch;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Un-verified employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                            <p>
                                <?php 
        $loggedin = Yii::$app->user->identity->user_id;
        $employer2 = EmployerSearch::getEmployer($loggedin);
        $employerID = $employer2->employer_id;
                                
        $unconfirmedEmployeeStatus= \frontend\modules\repayment\models\EmployedBeneficiary::find()
	        ->where(['verification_status'=>0,'confirmed'=>0,'employment_status'=>'ONPOST','upload_status'=>1,'employer_id'=>$employerID])
		->count();
        $failedUploadedEmployees= \frontend\modules\repayment\models\EmployedBeneficiary::find()
	        ->where(['upload_status'=>0,'employer_id'=>$employerID])
		->count();
        if($unconfirmedEmployeeStatus > 0 && $failedUploadedEmployees == 0){
        ?>
                                
                            <?=         
                    Html::a('Confirm All Employees', ['confirm-employeebulk'], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure you want to Confirm All Employees?',
                            'method' => 'post',
                        ],
                    ]);
                    ?>
        <?php } ?>
                                </p>
<p >
        <?=Html::beginForm(['confirm-uploaded-employee'],'post');?>        
              <div class="text-right">
                  <?php
                  if($unconfirmedEmployeeStatus > 0 && $failedUploadedEmployees == 0){
                  ?>
    <?=Html::submitButton('Confirm', ['class' => 'btn btn-warning',]);?>
                  <?php } ?>
        </div>  
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer.employer_name',
            [
                'attribute' => 'firstname',
                'label' => "First Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->firstname;
                },
            ],
			/*
            [
                'attribute' => 'middlename',
                'label' => "Middle Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->middlename;
                },
            ],
			*/
            [
                'attribute' => 'surname',
                'label' => "Last Name",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->surname;
                },
            ],
            [
                'attribute' => 'f4indexno',
                'label' => "Index Number",
                //'vAlign' => 'middle',
                'width' => '200px',
                'value' => function ($model) {
                    return $model->f4indexno;
                },
            ],
            [
                'attribute' => 'basic_salary',
                //'label' => "Basic Salary(TZS)",
                'hAlign' => 'right',
                'width' => '200px',
                'format' => ['decimal', 2],
                'value' => function ($model) {
            return $model->basic_salary;
        },
                'filter' => '',
            ],
            [
                'attribute' => 'loan_summary_id',
                'header' => 'Status',
                'filter' => '',
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->loan_summary_id == '') {
                        return '<p class="btn green"; style="color:red;">Pending Verification</p>';
                    } else {
                        return '<p class="btn green"; style="color:green;">Confirmed</p>';
                    }
                },
            ],
 
                        
                        [
                     'attribute' => 'confirmed',
                     'header' => 'Confirmed',       
                        'width' => '140px',
                        'value' => function ($model) {
                                   if($model->confirmed ==0){
                                     return Html::label("No", NULL, ['class'=>'label label-danger']);
                                    } else if($model->confirmed==1) {
                                        return Html::label("Yes", NULL, ['class'=>'label label-success']);
                                    }                                   
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[0=>"No",1=>'Yes'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                        
            ['class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
            ],
                        ['class' => 'yii\grid\CheckboxColumn'],
        ],
    ]);
    ?>
    <div class="text-right">
        <?php
                  if($unconfirmedEmployeeStatus > 0 && $failedUploadedEmployees == 0){
                  ?>
    <?=Html::submitButton('Confirm', ['class' => 'btn btn-warning',]);?>
                  <?php } ?>
        </div>
</div>
       </div>
</div>