<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use frontend\modules\repayment\models\RefundApplication;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationFramework */

$this->title ="Refund Verification Framework";
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Framework', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$model_test=RefundApplication::find()->where(["refund_verification_framework_id"=>$model->refund_verification_framework_id])->one();
?>
<div class="refund-verification-framework-view">
 <div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <p class="pull-right">
            <?= Html::a('Clone/Copy', ['save-as-new', 'id' => $model->refund_verification_framework_id], ['class' => 'btn btn-info']) ?>            
              <?php 
              if(count($model_test)==0){  ?>
            <?= Html::a('Update', ['update', 'id' => $model->refund_verification_framework_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Confirm Framework', ['confirm-framework', 'id' => $model->refund_verification_framework_id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Upload Support document', ['upload-support-document', 'id' => $model->refund_verification_framework_id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => 'Are you sure you want to  this item?',
                    'method' => 'post',
                ],
            ])
            ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->refund_verification_framework_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
              }
            ?>
            
     </p>
<?php 
    $gridColumn = [
       // 'refund_verification_framework_id',
        'verification_framework_title',
        'verification_framework_desc',
        //'verification_framework_stage',
        //'support_document',
        [
            'attribute' => 'confirmedBy.username',
            'label' => 'Confirmed By',
        ],
        'confirmed_at',
        //'is_active',
		[
                'attribute'=>'is_active',
                'label'=>'Is Active',
                'value'=>call_user_func(function ($data) {
                    if($data->is_active==1){
                return 'Yes';    
                }else{
                 return 'No';
                }
            }, $model),                
            ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
   
<?php
if($providerRefundVerificationFrameworkItem->totalCount){
    $gridColumnRefundVerificationFrameworkItem = [
        ['class' => 'yii\grid\SerialColumn'],
            //'refund_verification_framework_item_id',
                        [
                'attribute' => 'attachmentDefinition.attachment_desc',
                'label' => 'Attachment '
            ],
            'verification_prompt',
            //'status',
            //'is_active',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerRefundVerificationFrameworkItem,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-refund-verification-framework-item']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Refund Verification Framework Item'),
        ],
        'export' => false,
        'columns' => $gridColumnRefundVerificationFrameworkItem
    ]);
}
//echo $model->support_document;
?>
    </div>
</div>
