<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationFramework */

?>
<div class="refund-verification-framework-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->refund_verification_framework_id) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'refund_verification_framework_id',
        'verification_framework_title',
        'verification_framework_desc',
        'verification_framework_stage',
        'support_document',
        [
            'attribute' => 'confirmedBy.username',
            'label' => 'Confirmed By',
        ],
        'confirmed_at',
        'is_active',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>