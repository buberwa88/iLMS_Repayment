<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\GepgPaymentReconciliation */

$this->title = 'Create Gepg Payment Reconciliation';
$this->params['breadcrumbs'][] = ['label' => 'Gepg Payment Reconciliations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gepg-payment-reconciliation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
