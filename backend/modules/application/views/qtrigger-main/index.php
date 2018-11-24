<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\application\models\QtriggerMainSearch $searchModel
 */

$this->title = 'Question Triggers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qtrigger-main-index">
  <div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    <?php  echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'qtrigger_main_id',
            'description',
            [
               'attribute'=>'join_operator',
               'value'=>function($model){
                    if($model->join_operator == ''){
                        return 'Not Applicable';
                    } 
                    return $model->join_operator;
               }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['/application/qtrigger-main/update', 'id' => $model->qtrigger_main_id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit')]
                        );
                    }
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        //'floatHeader' => true,

//        'panel' => [
//            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
//            'type' => 'info',
//            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
//            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
//            'showFooter' => false
//        ],
    ]); 
     echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']);
   ?>

</div>
  </div>
</div>