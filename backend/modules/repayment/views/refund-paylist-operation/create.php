<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistOperation */

$this->title = 'Create Refund Paylist Operation';
$this->params['breadcrumbs'][] = ['label' => 'Refund Paylist Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-operation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
