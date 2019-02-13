<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundLetterFormat */

$this->title = 'Update Refund Letter Format: ';
$this->params['breadcrumbs'][] = ['label' => 'Refund Letter Format', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_letter_format_id, 'url' => ['view', 'id' => $model->refund_letter_format_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-letter-format-update">
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