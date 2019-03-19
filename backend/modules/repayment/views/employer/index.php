<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-index">

<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
						<p>
    <?= Html::a('Create Employer', ['create-employerheslb'], ['class' => 'btn btn-success']) ?>
	</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'employer_id',
            //'user_id',
            'employer_name',
            'employer_code',
            //'employer_type_id',
			[
                     'attribute' => 'employer_type_id',
                        'vAlign' => 'middle',                         
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->employerType->employer_type;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\repayment\models\EmployerType::find()->asArray()->all(), 'employer_type_id', 'employer_type'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            //'totatEmployees',
            [
            'attribute'=>'totatEmployees',
            'format'=>'raw',    
            'value' => function($model)
            {   
                   
                    return $model->getTotalEmployees($model->employer_id);

            },
        ],
                    [
            'attribute'=>'verification_status',
            'vAlign' => 'middle',
            'label'=>"Status",    
            'value' => function($model)
            {   
                   if($model->verification_status==1){
                    return '<p class="btn green"; style="color:green;">Confirmed</p>';
                   }else if($model->verification_status==3){
                    return '<p class="btn red"; style="color:red;">Deactivated</p>';   
                   }else if($model->verification_status==0){
                    return '<p class="btn red"; style="color:blue;">Pending Verification</p>';  
                   }else if($model->verification_status==2){
                   return '<p class="btn red"; style="color:black;">Waiting Activation</p>';
                   }

            },
			'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Pending Verification',1=>'Confirmed',2=>'Waiting Activation',3=>'Deactivated'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
        ],
            // 'postal_address',
            // 'phone_number',
            // 'physical_address',
            // 'ward_id',
            // 'email_address:email',
            // 'loan_summary_requested',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',                      
			],
			
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
