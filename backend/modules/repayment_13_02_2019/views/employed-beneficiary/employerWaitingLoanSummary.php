<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employers waiting Loan summary';
$this->params['breadcrumbs'][] = ['label' => 'Loan summary request categories', 'url' => ['/repayment/employed-beneficiary/loan-summary-requests-list']];
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
            'attribute'=>'employerName',            
            'format'=>'raw',    
            'value' => function($model)
            {   
  
                    return $model->employer->employer_name;
            },
        ],	
        [
            'attribute'=>'applicant_id',
            'header'=>'Total Employees',
            'filter'=>'',
            'format'=>'raw',    
            'value' => function($model)
            {   
  
                    return \backend\modules\repayment\models\EmployedBeneficiary::find()->where(['verification_status' =>'1','employment_status' =>'ONPOST','employer_id'=>$model->employer_id])->count();
            },
        ],
                    
            ['class' => 'yii\grid\ActionColumn',
                         'header' => 'Action',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',
                         'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('View Loan Summary', $url, ['class' => 'btn btn-success',
                            'title' => Yii::t('app', 'view'),
                ]);
            },

          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/loan-summary/view-loan-summary&employerID='.$model->employer_id;
                return $url;
            }
          }
			],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
