<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundLetterFormat */

$this->title = 'Create Refund Letter Format';
$this->params['breadcrumbs'][] = ['label' => 'Refund Letter Format', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-letter-format-create">
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