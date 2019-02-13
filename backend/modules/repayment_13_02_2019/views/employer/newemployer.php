<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'New Employers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employer-index">

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
                    return '<p class="btn green"; style="color:green;">Verified</p>';
                   }else if($model->verification_status==3){
                    return '<p class="btn red"; style="color:red;">Rejected</p>';   
                   }else if($model->verification_status==0){
                    return '<p class="btn red"; style="color:blue;">Pending Verification</p>';  
                   }

            },
			'filterType' => GridView::FILTER_SELECT2,
                        'filter' => [0=>'Pending Verification',1=>'Verified',3=>'Rejected'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search Any '],
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
                         'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('app', 'view'),
                ]);
            },

            'update' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('app', 'update'),
                ]);
            },
            'delete' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'delete'),
                ]);
            }

          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/employer/view-new-employer&id='.$model->employer_id;
                return $url;
            }

            if ($action === 'update') {
                $url ='index.php?r=repayment/employer/update&id='.$model->employer_id;
                return $url;
            }
            if ($action === 'delete') {
                $url ='index.php?r=repayment/employer/delete&id='.$model->employer_id;
                return $url;
            }

          }
			],
			
        ],
    ]); ?>
</div>
       </div>
</div>
