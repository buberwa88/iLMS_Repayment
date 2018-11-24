<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\PayMethod */

$this->title = 'Create Payment Method';
$this->params['breadcrumbs'][] = ['label' => 'Payment Methods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-method-create">
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
