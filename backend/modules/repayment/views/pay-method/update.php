<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\PayMethod */

$this->title = 'Update Payment Method: ' . $model->method_desc;
$this->params['breadcrumbs'][] = ['label' => 'Payment Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->method_desc, 'url' => ['view', 'id' => $model->pay_method_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
    <div class="payment-method-update">
    <div class="panel panel-info">
        <div class="panel-heading">
		<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
