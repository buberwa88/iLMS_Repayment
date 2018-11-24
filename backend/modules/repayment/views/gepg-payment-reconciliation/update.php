<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgPaymentReconciliation */

$this->title = 'Update Gepg Payment Reconciliation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gepg Payment Reconciliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gepg-payment-reconciliation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
