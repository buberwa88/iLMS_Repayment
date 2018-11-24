
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\application\models\QtriggerMainSearch $searchModel
 */

$this->title = 'Application Status';
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
              'application_cycle_status_name',
              //'application_cycle_status_description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'
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
