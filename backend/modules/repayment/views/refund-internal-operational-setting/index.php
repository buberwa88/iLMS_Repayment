<?php

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundInternalOperationalSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Refund Internal Operational Setting';
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);
?>
<div class="refund-internal-operational-setting-index">
 <div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <p>
        <?= Html::a('Create Refund Internal Operational Setting', ['create'], ['class' => 'btn btn-success']) ?>
       
    </p>
    
    <?php 
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
       //'refund_internal_operational_id',
        'name',
        //'code',
        //'access_role_master',
        //'access_role_child',
        'flow_order_list',
        //'is_active',
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
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-refund-internal-operational-setting']],
        
        'export' => false,
        // your toolbar can include the additional full export menu
    
    ]); ?>

</div>
</div>
</div>
