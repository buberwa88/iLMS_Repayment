<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ClusterDefinitionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Programme Clusters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-definition-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Cluster ', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'cluster_definition_id',
                    'cluster_name',
                    'cluster_desc',
                    'priority_order',
                    [
                        'attribute' => 'is_active',
                        'value' => function($model) {
                            return $model->getStatusName();
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
//                        'buttons' => [
//                            'update' => function ($url, $model, $key) {
//                                return $model->is_active === 1 ? Html::a('Update', $url) : '';
//                            },
//                            'delete' => function ($url, $model, $key) {
//                                return $model->is_active === 1 ? Html::a('Delete', $url) : '';
//                            },
//                        ]
                    ],
                ],
                'hover' => true,
                'condensed' => true,
                'floatHeader' => true,
            ]);
            ?>
        </div>
    </div>
</div>