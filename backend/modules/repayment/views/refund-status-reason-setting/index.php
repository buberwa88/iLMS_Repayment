<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundStatusReasonSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Refund Status Reason Setting';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="refund-status-reason-setting-index">
 <div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <p>
        <?= Html::a('Create Refund Status Reason Setting', ['create'], ['class' => 'btn btn-success']) ?>
       
    </p>
     
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        //'refund_status_reason_setting_id',
        //'status',
        [
            'attribute' => 'status',
            'label' => 'Status',
            'value' => function($model){
            if ($model->status)
            {
                return $model->status;
            }
            else
            {
                return NULL;
            }
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' =>[1=>"Valid", 2=>"Invalid",3=>"Waiting", 4=>"Incomplete"],
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Status', 'id' => 'grid-refund-comment-search-attachment_definition_id']
            ],
            [
                'attribute' => 'category',
                'label' => 'category',
                'value' => function($model){
                if ($model->category)
                {
                    return $model->category;
                }
                else
                {
                    return NULL;
                }
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' =>[1=>"Loan Refund Data Section", 2=>"Validation Section",3=>"Audit and Investigation"],
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'Category', 'id' => 'grid-category-search-attachment_definition_id']
                ],
        'reason',
        //'category',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{save-as-new} {update} {delete}',
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-refund-status-reason-setting']],
        
        'export' => false,
        // your toolbar can include the additional full export menu
      
    ]); ?>

</div>
</div>
</div>