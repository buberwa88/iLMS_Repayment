<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\EmployedBeneficiarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loanee new loan summary request';
$this->params['breadcrumbs'][] = ['label' => 'Loan Summary', 'url' => ['/repayment/loan-summary/loanee-waiting-bill']];
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
                            return $model->applicant->f4indexno;
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
                $url ='index.php?r=repayment/loan-summary/bill-prepation-loanee&loan_summary_id='.$model->loan_summary_id;
                return $url;
            }
          }
			],
        ],
    ]); ?>
</div>
       </div>
</div>
