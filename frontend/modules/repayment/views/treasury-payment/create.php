<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\TreasuryPayment */

$this->title = 'Create Treasury Payment';
$this->params['breadcrumbs'][] = ['label' => 'Treasury Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="treasury-payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
