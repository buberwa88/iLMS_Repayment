<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundComment */

$this->title = 'Save As New Refund Comment: '. ' ' . $model->refund_comment_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Comment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_comment_id, 'url' => ['view', 'id' => $model->refund_comment_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="refund-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
