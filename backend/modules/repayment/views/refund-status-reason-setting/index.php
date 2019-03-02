<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundStatusReasonSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
$verificationStatus = \backend\modules\repayment\models\RefundInternalOperationalSetting::getVerificationStatusGeneral();

$this->title = 'Refund Verification Comment';
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
                <?= Html::a('Create Refund Verification Comment', ['create'], ['class' => 'btn btn-success']) ?>

            </p>

            <?php
            $gridColumn = [
                ['class' => 'yii\grid\SerialColumn'],
				/*
                [
                    'attribute' => 'category',
                    'label' => 'category',
                    'value' => function($model) {
                        return $model->getApplcationProcessingSectionName();
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => [1 => "Loan Refund Data Section", 2 => "Validation Section", 3 => "Audit and Investigation"],
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Category', 'id' => 'grid-category-search-attachment_definition_id']
                ], 
				
				[
                    'attribute' => 'status',
                    'label' => 'Status',
                    'value' => function($model) {
                        return $model->getStatusTypeName();
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => function($model) {
                        return $verificationStatus;
                    },
                    'filterWidgetOptions' => [
                        'pluginOptions' => ['allowClear' => true],
                    ],
                    'filterInputOptions' => ['placeholder' => 'Status', 'id' => 'grid-refund-comment-search-attachment_definition_id']
                ],
				*/
				[
                     'attribute' => 'status',
                        'label'=>"Status",
                        'value' => function ($model) {
							if($model->status==1){
                           return 'Valid';
							}else if($model->status==2){
							return 'InValid';	
							}else if($model->status==3){
							return 'Need Further Verification';	
							}else if($model->status==4){
							return 'Need Investigation';	
							}
                        },
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
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumn,
                        'pjax' => true,
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-refund-status-reason-setting']],
                        'export' => false,
                            // your toolbar can include the additional full export menu
                    ]);
                    ?>

        </div>
    </div>
</div>