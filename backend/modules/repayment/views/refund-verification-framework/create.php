<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationFramework */

$this->title = 'Create Refund Verification Framework';
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Framework', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
