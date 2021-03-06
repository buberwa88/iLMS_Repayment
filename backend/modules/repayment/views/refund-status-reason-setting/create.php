<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundStatusReasonSetting */

$this->title = 'Create Refund Verification Comment';
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Comment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-status-reason-setting-create">
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