<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationResponseSetting */

$this->title = 'Update Refund Verification Response Setting: ' . $model->refund_verification_response_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Response Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_verification_response_setting_id, 'url' => ['view', 'id' => $model->refund_verification_response_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-verification-response-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
