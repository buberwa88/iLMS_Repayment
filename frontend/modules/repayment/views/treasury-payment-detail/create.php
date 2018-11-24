<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPaymentDetail */

$this->title = 'Create Treasury Payment Detail';
$this->params['breadcrumbs'][] = ['label' => 'Treasury Payment Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasury-payment-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
