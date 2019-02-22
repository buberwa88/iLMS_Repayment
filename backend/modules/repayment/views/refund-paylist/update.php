<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylist */

$this->title = 'Update Refund Paylist: ' . $model->refund_paylist_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Paylists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_paylist_id, 'url' => ['view', 'id' => $model->refund_paylist_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-paylist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
