<?php
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\modules\repayment\models\LoanSummary;
//echo $employer_id;
$LoanSummaryModel=new LoanSummary();
$resultsEmployer=$LoanSummaryModel->getEmployerDetails($employer_id);
//$billNumber=$resultsEmployer->employer_code."-".date("Y")."-".date("m")."-".date("d").date("H").date("i").date("s");
$billNumber=$resultsEmployer->employer_code."-".date("Y")."-".$LoanSummaryModel->getLastBillID($employerID);
$tracedBy=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;

$totalEmployees=$searchModel->getAllEmployeesUnderBillunderEmployer($employer_id);
$totalAcculatedLoan=$searchModel->getTotalLoanInBill($employer_id);
$this->title = 'CREATE NEW BILL';
?>

<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                          <?= Html::encode($this->title) ?>  
                        </div>
    
                        <div class="panel-body">
                            <?= $this->render('_form', [
                                'model' => $model,'employer_name'=>$resultsEmployer->employer_name,'employer_code'=>$resultsEmployer->employer_code,
                                'billNumber'=>$billNumber,'tracedBy'=>$tracedBy,'number_employees'=>$resultsEmployer->employer_code,'employer_id'=>$employer_id,
                                'totalEmployees'=>$totalEmployees,'totalLoanInBill'=>$totalAcculatedLoan,
                                ]) ?>
                            
                            <br/>
                            <h3>Loanees in this bill.</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           // 'employer.employer_name',
            [
            'attribute'=>'applicant_id',
            'header'=>'Loaneeid',
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return '';
                }
                else
                {   
                    return $model1->applicant_id;
                }
            },
        ],
            [
            'attribute'=>'f4indexno',
            'header'=>'Indexno',
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return $model1->f4indexno;
                }
                else
                {   
                    return $model1->applicant->f4indexno;
                }
            },
        ],
            [
            'attribute'=>'applicant_id',
            'header'=>'Full Name',
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return $model1->firstname;
                }
                else
                {   
                    return $model1->applicant->user->firstname.", ".$model1->applicant->user->middlename." ".$model1->applicant->user->surname;
                }
            },
        ],
                    [
            'attribute'=>'principal',
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return $model1->getIndividualEmployeesPrincipalLoan($model1->applicant_id);
                }
                else
                {   
                    return $model1->getIndividualEmployeesPrincipalLoan($model1->applicant_id);
                }
            },
        ],
                    [
            'attribute'=>'penalty',
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return $model1->getIndividualEmployeesPenalty($model1->applicant_id);
                }
                else
                {   
                    return $model1->getIndividualEmployeesPenalty($model1->applicant_id);
                }
            },
        ],
                    [
            'attribute'=>'LAF',
            'label'=>'LAF',             
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return $model1->getIndividualEmployeesLAF($model1->applicant_id);
                }
                else
                {   
                    return $model1->getIndividualEmployeesLAF($model1->applicant_id);
                }
            },
        ],
                    [
            'attribute'=>'VRF',
            'label'=>'VRF',            
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return $model1->getIndividualEmployeesVRF($model1->applicant_id);
                }
                else
                {   
                    return $model1->getIndividualEmployeesVRF($model1->applicant_id);
                }
            },
        ],
                    [
            'attribute'=>'totalLoan',
            //'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return $model1->getIndividualEmployeeTotalLoan($model1->applicant_id);
                }
                else
                {   
                    return $model1->getIndividualEmployeeTotalLoan($model1->applicant_id);
                }
            },
        ],
 
                    [
            'attribute'=>'applicant_id',
            'header'=>'Beneficiary',
            'filter' => '',
            'format'=>'raw',    
            'value' => function($model1)
            {   
                if($model1->applicant_id == '')
                {
                    return '<p class="btn green"; style="color:red;">Not Found</p>';
                }
                else
                {   
                    return '<p class="btn green"; style="color:green;">OK</p>';
                }
            },
        ],
            [
        'label'=>'Action',
        'format' => 'raw',
        'value'=>function ($model1) {
                if($model1->applicant_id == '')
                {
        return Html::a('Remove', ['bill-prepation','employerID'=>$model1->employer_id], ['class' => 'btn btn-success']);
        //return Html::a('Prepare Bill', ['bill-prepation'], ['class' => 'btn btn-success']);
                }else{
        return '';
                }
        },
       ],
                    
        ],
    ]); ?>
</div>
       </div>
</div>

