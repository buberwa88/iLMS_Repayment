<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundPaylistDetails */

$this->title = 'Create Refund Paylist Details';
$this->params['breadcrumbs'][] = ['label' => 'Refund Paylist Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
