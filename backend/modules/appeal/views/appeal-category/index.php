<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\appeal\models\AppealCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'List of Appeal Category';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="appeal-category-index">
 <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        <div class="panel-body">
    <p>
        <?= Html::a('Create Appeal Category', ['create'], ['class' => 'btn btn-success']) ?>
         
    </p>
    
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        //'appeal_category_id',
        'name',
        'description:ntext',
        //'status',
        [
            'attribute' => 'status',
            'label' => 'Status',
            'value' => function($model){
            if ($model->status)
            {return $model->status==1?'Active':'Inactive';}
            else
            {return NULL;}
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' =>[1=>'Active',0=>'InActive'],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Status', 'id' => 'grid-asset-category-search-categoryId']
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-appeal-category']],
         
        //'export' => false,
        // your toolbar can include the additional full export menu
       
    ]); ?>

</div>
</div>
</div>
