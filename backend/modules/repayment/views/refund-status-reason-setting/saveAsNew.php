<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundStatusReasonSetting */

$this->title = 'Save As New Refund Status Reason Setting: '. ' ' . $model->refund_status_reason_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Status Reason Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_status_reason_setting_id, 'url' => ['view', 'id' => $model->refund_status_reason_setting_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="refund-status-reason-setting-create">
 <div class="panel panel-info">
                        <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
                        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>