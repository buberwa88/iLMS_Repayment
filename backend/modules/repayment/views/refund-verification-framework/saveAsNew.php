<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationFramework */

$this->title = 'Save As New Refund Verification Framework: ';
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Framework', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->refund_verification_framework_id, 'url' => ['view', 'id' => $model->refund_verification_framework_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="refund-verification-framework-create">
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