<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundStatusReasonSetting */

$this->title = "Refund Status Reason Setting ";
$this->params['breadcrumbs'][] = ['label' => 'Refund Status Reason Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-status-reason-setting-view">

   <p>
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->refund_status_reason_setting_id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->refund_status_reason_setting_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->refund_status_reason_setting_id], [
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
        //'refund_status_reason_setting_id',
        'status',
        'reason',
        'category',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    
   
</div>
