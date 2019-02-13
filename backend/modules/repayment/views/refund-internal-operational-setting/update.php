<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundInternalOperationalSetting */

$this->title = 'Update Refund Internal Operational Setting: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Refund Internal Operational Setting', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->refund_internal_operational_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-internal-operational-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
