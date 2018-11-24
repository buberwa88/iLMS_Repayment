<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationStructureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'List of Allocation Structure';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="allocation-structure-index">
  <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Create Allocation Structure', ['create'], ['class' => 'btn btn-success']) ?>
     
    </p>
   
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
       // 'allocation_structure_id',
        'structure_name',
        'parent_id',
        'order_level',
        //'status',
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
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{save-as-new} {view} {update} {delete}',
            'buttons' => [
                'save-as-new' => function ($url) {
                    return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, ['title' => 'Save As New']);
                },
            ],
        ],
    ]; 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-allocation-structure']],
      
    ]); ?>

</div>
