<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'employer_id',
            'user_id',
            'employer_name',
            'employer_code',
            'employer_type_id',
            // 'postal_address',
            // 'phone_number',
            // 'physical_address',
            // 'ward_id',
            // 'email_address:email',
            // 'loan_summary_requested',
            // 'created_at',

            //['class' => 'yii\grid\ActionColumn'],
			
			['class' => 'yii\grid\ActionColumn',
                         'header' => 'Actions',
                         'headerOptions' => ['style' => 'color:#337ab7'],
			 'template'=>'{view}',
                         'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('View', $url, ['class' => 'btn btn-success',
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
                $url ='index.php?r=repayment/employer/view&id='.$model->employer_id;
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
