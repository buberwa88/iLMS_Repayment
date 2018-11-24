<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List  of Allocated Student';
$this->params['breadcrumbs'][] = $this->title;
   $searchModel = new \backend\modules\allocation\models\AllocationSearch();
   $dataProvider = $searchModel->searchloaniteam(Yii::$app->request->queryParams,$model);
  //SELECT `firstname`, `middlename`, `surname`, `f4indexno`,`programme_id` FROM `user` u join applicant ap on u.`user_id`=ap.`user_id` join application apl on apl.`applicant_id`=ap.`applicant_id` join allocation all on all.`application_id`=apl.`application_id` WHERE  1
?>
<div class="allocation-index">
   <div class="panel panel-info">
                        <div class="panel-heading">
                      <?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
                            
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'allocation_id',
           // 'allocation_batch_id',
           // '',
//                   [
//                     'attribute' => 'firstName',
//                        'label'=>"First Name",
//                        'vAlign' => 'middle',
//                        //'width' => '200px',
//                        'value' => function ($model) {
//                            return $model->application->applicant->user->firstname;
//                        },
//                    ],
//                    [
//                     'attribute' => 'surName',
//                         'label'=>"Last Name",
//                        'vAlign' => 'middle',
//                         
//                       // 'width' => '200px',
//                        'value' => function ($model) {
//                            return $model->application->applicant->user->surname;
//                        },
//                    ],
//                    [
//                     'attribute' => 'f4indexno',
//                        'label'=>"f4 Index #",
//                        'vAlign' => 'middle',
//                        'width' => '200px',
//                        'value' => function ($model) {
//                            return $model->application->applicant->f4indexno;
//                        },
//                    ],
           
                    [
                        'attribute' => 'loan_item_id',
                        'vAlign' => 'middle',
                       // 'width' => '200px',
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
           // 'allocated_amount',
                  [
                      'attribute' => 'allocated_amount',
                      
                     'hAlign'=>'right',
                          'format'=>['decimal', 2],
                        //'label'=>"Status",
                        'width' => '130px',    
                  ],                                  
            // 'is_canceled',
            // 'cancel_comment:ntext',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
   </div>
</div>