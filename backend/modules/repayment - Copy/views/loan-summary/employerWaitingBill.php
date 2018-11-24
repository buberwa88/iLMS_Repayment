<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employer New Bill(Terminated Employees)';
$this->params['breadcrumbs'][] = ['label' => 'Employer Waiting Bill', 'url' => ['/repayment/employed-beneficiary/employer-waiting-bill']];
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
            'employer.employer_name',
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
                return Html::a('Send Bill', $url, ['class' => 'btn btn-success',
                            'title' => Yii::t('app', 'view'),
                ]);
            },

          ],
        'urlCreator' => function ($action, $model, $key, $index) {
            if ($action === 'view') {
                $url ='index.php?r=repayment/loan-summary/bill-prepation&employerID='.$model->employer_id;
                return $url;
            }
          }
			],
        ],
    ]); ?>
</div>
       </div>
</div>
