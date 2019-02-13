<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundLetterFormat */

$this->title = 'Save As New Refund Letter Format: '. ' ' . $model->refund_letter_format_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Letter Format', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_letter_format_id, 'url' => ['view', 'id' => $model->refund_letter_format_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="refund-letter-format-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
