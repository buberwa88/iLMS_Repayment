<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundComment */

$this->title = 'Update Refund Comment: ';
$this->params['breadcrumbs'][] = ['label' => 'Refund Comment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>"Refund List", 'url' => ['view', 'id' => $model->refund_comment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="refund-comment-update">
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