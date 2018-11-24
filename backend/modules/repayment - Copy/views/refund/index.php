<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Refund Claims';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-index">
<div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
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
			[
                     'attribute' => 'surname',
                        'label'=>"Last Name",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->user->surname;
                        },
            ],
			[
                     'attribute' => 'f4indexno',
                        'label'=>"Index Number",
                        //'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->applicant->f4indexno;
                        },
            ],
			[
                     'attribute' => 'amount',
                        'label'=>"Amount",
                        'hAlign' => 'right',
                        'value' => function ($model) {
                           return $model->amount;
                        },
						'format'=>['decimal',2],
            ],

            ['class' => 'yii\grid\ActionColumn',
			'header'=>'Action',
			'template'=>'{view}{update}',
			],
        ],
		'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
       </div>
</div>
