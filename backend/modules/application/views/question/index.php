<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\application\models\QuestionSearch $searchModel
 */

$this->title = 'List of Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">
   <div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Question', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php  echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'allowBatchToggle' => true,
                'detail' => function ($model) {
                  return $this->render('view',['model'=>$model]);  
                },
                'detailOptions' => [
                    'class' => 'kv-state-enable',
                ],
                ],
            //'question_id',
            'question',
            'response_control',
            'response_data_type',
            [
              'attribute'=>'is_active',
              'value'=>function($model){
                if($model->is_active == 1){
                    return Html::label("YES", NULL, ['class'=>'label label-success']);
                } else {
                    return Html::label("NO", NULL, ['class'=>'label label-danger']);
                }
              },
              'format'=>'raw',
              'filter'=>[1=>'YES',0=>'NO']
            ],
          //  'response_data_length',
            //'hint', 
            //'qresponse_source_id', 
            [
              'attribute'=>'require_verification',
              'value'=>function($model){
                if($model->require_verification == 1){
                    return Html::label("YES", NULL, ['class'=>'label label-success']);
                } else {
                    return Html::label("NO", NULL, ['class'=>'label label-danger']);
                }
              },
              'format'=>'raw',
              'filter'=>[1=>'YES',0=>'NO']
            ],
          //  'verification_prompt', 
            
//             [
//               'label'=>'',
//               'value'=>function($model){
//                  return Html::a("Update|Details", ['/application/question/update','id'=>$model->question_id], ['class'=>'label label-primary']);
//               },
//               'format'=>'raw',
//             ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['/application/question/update', 'id' => $model->question_id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
                        );
                    }
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,
 
    ]);  ?>

</div>
   </div>
</div>
