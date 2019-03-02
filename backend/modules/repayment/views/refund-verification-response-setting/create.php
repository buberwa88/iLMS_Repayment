<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\RefundVerificationResponseSetting */

$this->title = 'Create Refund Verification Response';
$this->params['breadcrumbs'][] = ['label' => 'Refund Verification Response', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-verification-response-setting-create">
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
