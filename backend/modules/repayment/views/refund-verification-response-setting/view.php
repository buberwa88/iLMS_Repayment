<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationResponseSetting */

$this->title = $model->refund_verification_response_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Response Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-verification-response-setting-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->refund_verification_response_setting_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->refund_verification_response_setting_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'refund_verification_response_setting_id',
            'verification_status',
            'response_code',
            'access_role_master',
            'access_role_child',
            'reason',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'is_active',
        ],
    ]) ?>

</div>
