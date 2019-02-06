<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */

$this->title = 'Update Refund Education History: ' . $model->refund_education_history_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Education Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_education_history_id, 'url' => ['view', 'id' => $model->refund_education_history_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-education-history-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
