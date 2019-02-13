<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */

$this->title = 'Step 4: Court Details';
//$this->params['breadcrumbs'][] = ['label' => 'Refund Claimants', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-claimant-create">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

    <?= $this->render('_form_courtDetails', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
