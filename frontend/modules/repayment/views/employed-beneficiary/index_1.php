<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employed Beneficiaries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=''; //Html::a('Add Employee Loan Beneficiary', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Download Template', ['download'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload Employees Loan Beneficiaries', ['upload-general'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'employer.employer_name',
            [
            'attribute'=>'applicant_id',
            'header'=>'Full Name',
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->applicant_id == '')
                {
                    return $model->firstname;
                }
                else
                {   
                    return $model->applicant->user->firstname." ".$model->applicant->user->middlename." ".$model->applicant->user->surname;
                }
            },
        ],
                    [
            'attribute'=>'f4indexno',
            'header'=>'Index Number',
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->applicant_id == '')
                {
                    return $model->f4indexno;
                }
                else
                {   
                    return $model->applicant->f4indexno;
                }
            },
        ],
                    [
            'attribute'=>'NID',
            'header'=>'NIN',
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->applicant_id == '')
                {
                    return $model->NID;
                }
                else
                {   
                    return $model->applicant->NID;
                }
            },
        ],
                    
            //'applicant.f4indexno',
            'employee_id',
            //'applicant.NID',            
            'basic_salary',
            'employment_status',
                    [
            'attribute'=>'loan_summary_id',
            'header'=>'Status',
            'filter' => '',
            'format'=>'raw',    
            'value' => function($model)
            {   
                if($model->loan_summary_id == '')
                {
                    return '<p class="btn green"; style="color:red;">Pending Verification</p>';
                }
                else
                {   
                    return '<p class="btn green"; style="color:green;">Confirmed</p>';
                }
            },
        ],
            ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}'],
        ],
    ]); ?>
</div>
       </div>
</div>
