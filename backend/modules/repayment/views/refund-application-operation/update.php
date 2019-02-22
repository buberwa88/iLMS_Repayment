<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundApplicationOperation */

$this->title = 'Update Refund Application Operation: ' . $model->refund_application_operation_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Application Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_application_operation_id, 'url' => ['view', 'id' => $model->refund_application_operation_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-application-operation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
