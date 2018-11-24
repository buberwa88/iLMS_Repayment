<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\application\models\TemplatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="templates-index">
  <div class="panel panel-info">
    <div class="panel-heading">
        <?= Html::encode($this->title) ?>
    </div>

 <div class="panel-body">
    <?php  echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'template_id',
            'template_name',
             [
               'attribute' => 'template_content',
                'label'=>"Template Content",
                'value' => function ($model) {
                            return strip_tags($model->template_content);
                    },
              ],
            //'template_content:ntext',
            //'template_status',             
             [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}',
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
    ]); 
     echo Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']);
   ?>
</div>
</div>
</div>

