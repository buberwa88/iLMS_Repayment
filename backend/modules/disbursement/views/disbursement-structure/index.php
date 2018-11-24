<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementStructureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Disbursement Structure';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-structure-index">
   <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Disbursement Structure', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'disbursement_structure_id',
            'structure_name',
            //'parent_id',
                [
                        'attribute' => 'parent_id',
                        'vAlign' => 'middle',
                        //'width' => '200px',
                        'value' => function ($model) {
                            return $model->parent->structure_name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(backend\modules\disbursement\models\DisbursementStructure::find()->asArray()->all(),'disbursement_structure_id','structure_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search'],
                        'format' => 'raw'
                    ],
            //'order_level',
               [
                        'attribute' => 'order_level',
                        'vAlign' => 'middle',
                        'width' => '100px',
                   ],
           // 'status',
              [
                        'attribute' => 'status',
                        'vAlign' => 'middle',
                        'width' => '100px',
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
        'hover' => true,
        'condensed' => true,
       'floatHeader' => true,
    ]); ?>
</div>
   </div>
</div>