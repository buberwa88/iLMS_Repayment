<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\application\models\Question;
use backend\modules\application\models\QresponseList;
use backend\modules\application\models\AttachmentDefinition;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\application\models\QpossibleResponseSearch $searchModel
 */

$this->title = 'Qpossible Responses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qpossible-response-index">


    <?php 
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

        
             [
                'attribute'=>'qresponse_list_id',
                'value'=>function($model){
                    return QresponseList::findOne($model->qresponse_list_id)->response;
                }
             ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>"{update}{delete}",
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['application/qpossible-response/update', 'id' => $model->qpossible_response_id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            Yii::$app->urlManager->createUrl(['application/qpossible-response/delete', 'id' => $model->qpossible_response_id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
                        );
                    }
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
       // 'floatHeader' => true,

//        'panel' => [
//            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
//            'type' => 'info',
//            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
//            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
//            'showFooter' => false
//        ],
    ]); 
                
     echo $this->render('_form',['model'=>$model, 'question_id'=>$question_id])           
     ?>

</div>
