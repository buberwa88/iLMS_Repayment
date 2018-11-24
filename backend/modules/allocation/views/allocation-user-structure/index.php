<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationUserStructureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use common\models\User;

$this->title = 'Assign Allocation Staff to Allocation Structure';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="allocation-user-structure-index">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?= Html::a('Assign Staff to Allocation  Structure', ['create'], ['class' => 'btn btn-success']) ?>
      
    </p>
     
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
      //  'allocation_user_structure_id',
        [
                'attribute' => 'allocation_structure_id',
                'label' => 'Allocation Structure',
                'value' => function($model){                   
                return $model->allocationStructure->structure_name;                   
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(\backend\modules\allocation\models\AllocationStructure::find()->asArray()->all(), 'allocation_structure_id', 'structure_name'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Allocation structure', 'id' => 'grid-allocation-user-structure-search-allocation_structure_id']
            ],
        [
                'attribute' => 'user_id',
                'label' => 'User',
                'value' => function($model){                   
                    return $model->user->username;                   
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(User::find()->where(['login_type'=>5])->asArray()->all(), 'user_id', 'username'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'User', 'id' => 'grid-allocation-user-structure-search-user_id']
            ],
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-allocation-user-structure']],
       /* 'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],*/
        //'export' => false,
        // your toolbar can include the additional full export menu
       
    ]); ?>

</div>
</div>
</div>