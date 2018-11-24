<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Beneficiaries Submitted(Waiting employers confirmation)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employed-beneficiary-index">

<div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">   
                        <?php 
                            
                            if($totalUnverifiedEmployees > 0){ ?>
                            <p>        
		<?=Html::beginForm(['employed-beneficiary/resubmit-beneficiary'],'post');?>
        <?=Html::submitButton('Re-submit selected beneficiaries', ['class' => 'btn btn-success',]);?>
                
    </p>
                            <?php } ?>						

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
				return backend\modules\repayment\models\LoanSummaryDetail::getTotalLoanBeneficiaryOriginal($model->applicant_id);
        },
            ],
			/*
            [
                'attribute' => 'basic_salary',
                'label' => "Basic Salary",
                'hAlign' => 'right',
                'format' => ['decimal', 2],
                'value' => function ($model) {
                return $model->basic_salary;
        },
            ],	
*/	
        ['class' => 'yii\grid\CheckboxColumn'],		
                               
        ],
    ]); ?>
	<?php if($totalUnverifiedEmployees > 0){ ?>
	<?= Html::endForm();?>
	<?php } ?>
</div>
       </div>
</div>
