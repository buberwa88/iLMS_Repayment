<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\appeal\models\AppealPlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use common\models\AcademicYear;

$this->title = 'List of Appeal Plan';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="appeal-plan-index">
 <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Appeal Plan', ['create'], ['class' => 'btn btn-success']) ?>
       
    </p>
  
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        //'appeal_plan_id',
        [
                'attribute' => 'academic_year_id',
                'label' => 'Academic Year',
                'value' => function($model){
                    if ($model->academicYear)
                    {return $model->academicYear->academic_year;}
                    else
                    {return NULL;}
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \yii\helpers\ArrayHelper::map(AcademicYear::find()->asArray()->all(), 'academic_year_id', 'academic_year'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Academic year', 'id' => 'grid-appeal-plan-search-academic_year_id']
            ],
        'appeal_plan_title',
       // 'appeal_plan_desc',
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-appeal-plan']],
        
    ]); ?>

</div>
</div>
</div>
