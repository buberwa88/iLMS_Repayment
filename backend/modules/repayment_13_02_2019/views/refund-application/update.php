<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundApplication */

$this->title = 'Update Refund Application: ' . $model->refund_application_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_application_id, 'url' => ['view', 'id' => $model->refund_application_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-application-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
