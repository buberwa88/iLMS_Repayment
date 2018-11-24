<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-task-index">
  <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Disbursement Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'disbursement_task_id',
            'task_name',
             [
                        'attribute' => 'status',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->status==1?'Active':'Inactive';
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' =>[1=>'Active',2=>'Inactive'],
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}'],
        ],
    ]); ?>
</div>
  </div></div>
