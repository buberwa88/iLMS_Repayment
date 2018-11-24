<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\application\models\QresponseListSearch $searchModel
 */

$this->title = 'List of Question Response';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qresponse-list-index">
     <div class="panel panel-info">
        <div class="panel-heading">
         
<?= Html::encode($this->title) ?>
          
        </div>
        <div class="panel-body">
              <p>
        <?= Html::a('Create Question Response', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php  echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'response',
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['application/qresponse-list/update', 'id' => $model->qresponse_list_id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
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
    ]);  ?>

</div>
     </div>
</div>