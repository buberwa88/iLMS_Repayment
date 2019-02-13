<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\LoanBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer Penalty';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-beneficiary-index">
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
			'attribute'=>'employer_id',
            'label'=>'Employer',
            'format'=>'raw',    
            'value' => function($model)
            {   
                   
                    return $model->employer->employer_name;

            },
        ],
			[
            'attribute'=>'amount',
            'format'=>'raw',    
            'value' =>function($model)
            {
                 return $model->amount;
            }, 
            'format'=>['decimal',2],
			'hAlign' => 'right',
            ],
            'penalty_date',
			[
			'attribute'=>'is_active',
            'label'=>'Status',
            'format'=>'raw',    
            'value' => function($model)
            {   
                   if($model->is_active==1){
					 $status='<p class="btn green"; style="color:green;">Active</p>';
				   }else{
					  $status='<p class="btn green"; style="color:red;">Cancelled</p>';  
				   }
                    return $status;

            },
        ],
            //['class' => 'yii\grid\ActionColumn'],
			[
                'label' => ' ',
               'value' => function ($model) {
                if ((($model->is_active == 1))) {
                        return Html::a('<span class="label label-danger">Cancel</span>', Yii::$app->urlManager->createUrl(['/repayment/employer/cancel-penalty', 'id' => $model->employer_penalty_id]), [
                                    'title' => Yii::t('yii', 'Cancel'),
                                    'data' => ['confirm' => 'Are you sure you want to cancel employer penalty?'],
                        ]);
                    } else {
                        return ' ';
                    }
                },
                        'format' => 'raw',
                    ],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
