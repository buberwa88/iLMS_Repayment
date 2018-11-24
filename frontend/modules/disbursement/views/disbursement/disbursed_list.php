<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Disbursement';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-index">
 <div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                            <p>
        <?php //= Html::a('Add Student', ['create','id'=>$id], ['class' => 'btn btn-success']) ?>
                     </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'disbursement_id',
           //'disbursement_batch_id',
           // 'application.applicant.user.username',
           // 'application_id',
               [
                     'attribute' => 'firstName',
                        'label'=>"First Name",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->application->applicant->user->firstname;
                        },
                    ],
                    [
                     'attribute' => 'lastName',
                        'vAlign' => 'middle',
                         
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->application->applicant->user->surname;
                        },
                    ],
                    [
                     'attribute' => 'f4indexno',
                        'label'=>"f4 Index #",
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->application->applicant->f4indexno;
                        },
                    ],
                    [
                        'attribute' => 'programme_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->programme->programme_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\Programme::find()->asArray()->all(), 'programme_id', 'programme_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
                    [
                        'attribute' => 'loan_item_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->loanItem->item_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
            // 'disbursed_amount',
                [
                      'attribute' => 'disbursed_amount',
                     'hAlign'=>'right',
                          'format'=>['decimal', 2],
                        //'label'=>"Status",
                        'width' => '200px',    
                  ],                              
             //'status',
           // 'application.applicant.f4indexno',
            // 'created_at',
            // 'created_by',

//            ['class' => 'yii\grid\ActionColumn',
//                'template'=>'{update}{delete}'],
        ],
       'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
 </div>
</div>