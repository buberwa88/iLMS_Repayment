<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundInternalOperationalSetting */

$this->title = 'Update Refund Operational Setting';
$this->params['breadcrumbs'][] = ['label' => 'Refund Operational Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->refund_internal_operational_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-internal-operational-setting-update">
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
