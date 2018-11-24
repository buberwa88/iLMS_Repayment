<?php
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\repayment\models\LoanSummary;


$this->title = 'Verify and Approve Loan';
$this->params['breadcrumbs'][] = ['label' => 'Employer Waiting Loan', 'url' => ['/repayment/employed-beneficiary/employer-waiting-bill']];
$this->params['breadcrumbs'][] = $this->title;


//echo $employer_id;
$LoanSummaryModel=new LoanSummary();
$resultsEmployer=$LoanSummaryModel->getEmployerDetails($employer_id);
//$billNumber=$resultsEmployer->employer_code."-".date("Y")."-".date("m")."-".date("d").date("H").date("i").date("s");
$billNumber=$resultsEmployer->employer_code."-".date("Y")."-".$LoanSummaryModel->getLastBillID($employer_id);
$tracedBy=Yii::$app->user->identity->firstname." ".Yii::$app->user->identity->middlename." ".Yii::$app->user->identity->surname;

$totalEmployees=$searchModel->getAllEmployeesUnderBillunderEmployer($employer_id);
$totalAcculatedLoan=$searchModel->getTotalLoanInBill($employer_id);
$this->title = 'Verify and Approve Bill';
$billNote="Due to Value Retention Fee(VRF) which is charged daily, the total loan amount will be changing accordingly.";
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
                                'totalEmployees'=>$totalEmployees,'totalLoanInBill'=>$totalAcculatedLoan,'billNote'=>$billNote,
                                ]) ?>
                            
                            <br/>
                            <h3>Loanees.</h3>
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
            'label' =>'Principal',
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
            'format'=>['decimal',2],
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
            'format'=>['decimal',2],        
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
            'format'=>['decimal',2],
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
            'format'=>['decimal',2],        
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
            'format'=>['decimal',2],
        ],          
        ],
    ]); ?>
</div>
       </div>
</div>

