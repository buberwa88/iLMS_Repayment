<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationResponseSetting */

$this->title = 'Update Refund Verification Response Setting';
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Response Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_verification_response_setting_id, 'url' => ['view', 'id' => $model->refund_verification_response_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-verification-response-setting-index">
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
