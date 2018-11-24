<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructure */

$this->title = 'Allocation Structure Detail';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-structure-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title); ?>
        </div>
        <div class="panel-body">
        <p>
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->allocation_structure_id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->allocation_structure_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->allocation_structure_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>
<?php 
    $gridColumn = [
       // 'allocation_structure_id',
        'structure_name',
        'parent_id',
        'order_level',
        //'status',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
  
<?php
if($providerAllocationUserStructure->totalCount){
    $gridColumnAllocationUserStructure = [
        ['class' => 'yii\grid\SerialColumn'],
            //'allocation_user_structure_id',
                        [
                'attribute' => 'user.username',
                'label' => 'Full Name'
            ],
        [
            'attribute' => 'status',
            'vAlign' => 'middle',
            // 'label' => "Status",
            'width' => '200px',
            'value' => function ($model) {
            return $model->status==1?'Active':'Inactive';
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => [1 => 'Active', 0 => 'Inactive'],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Search'],
            'format' => 'raw'
                ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAllocationUserStructure,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-allocation-user-structure']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Allocation Staff '),
        ],
        'export' => false,
        'columns' => $gridColumnAllocationUserStructure
    ]);
}
?>

    </div>
</div>
</div>