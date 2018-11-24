<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\Refund */

$this->title = 'Update Refund Claim';
$this->params['breadcrumbs'][] = ['label' => 'Refunds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->refund_id, 'url' => ['view', 'id' => $model->refund_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-view">
    <div class="panel panel-info">
	    <div class="panel-heading">
						<?= Html::encode($this->title) ?>
                        </div>
        <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,'applicantID'=>$applicantID,'upID'=>$upID,
    ]) ?>

</div>
    </div>
</div>
