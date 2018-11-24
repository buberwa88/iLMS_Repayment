<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructure */

$this->title = $model->allocation_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-structure-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Allocation Structure'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
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
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'allocation_structure_id',
        'structure_name',
        'parent_id',
        'order_level',
        'status',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
    <div class="row">
<?php
if($providerAllocationUserStructure->totalCount){
    $gridColumnAllocationUserStructure = [
        ['class' => 'yii\grid\SerialColumn'],
            'allocation_user_structure_id',
                        [
                'attribute' => 'user.username',
                'label' => 'User'
            ],
            'status',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAllocationUserStructure,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-allocation-user-structure']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Allocation User Structure'),
        ],
        'export' => false,
        'columns' => $gridColumnAllocationUserStructure
    ]);
}
?>

    </div>
</div>
