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
                           <?php if($totalEmployees > 0){ ?>
            <p>
        <?= Html::a('Submit Beneficiaries', ['bulk-beneficiaries-submited'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'employer.employer_name',
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
            ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',
                         'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('View', $url, ['class' => 'btn btn-success',
                            'title' => Yii::t('app', 'view'),
                ]);
            },

          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/employed-beneficiary/view&id='.$model->employed_beneficiary_id;
                return $url;
            }
          }
			],
        ],
    ]); ?>
</div>
       </div>
</div>
