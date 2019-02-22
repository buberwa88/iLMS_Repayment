<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundComment */

$this->title = 'Create Refund Comment';
$this->params['breadcrumbs'][] = ['label' => 'Refund Comment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-comment-create">
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