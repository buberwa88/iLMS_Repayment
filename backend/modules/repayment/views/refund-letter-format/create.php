<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundLetterFormat */

$this->title = 'Create/Add Refund Letter Configuration';
$this->params['breadcrumbs'][] = ['label' => 'Refund Letter Configuration', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create/Add Letter ';
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