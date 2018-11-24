<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovement */

$this->title = 'Forward  Payout List';
$this->params['breadcrumbs'][] = ['label' => 'Payoutlist', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payoutlist-movement-create">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_cancel', [
        'model' => $model,
        'disbursementId'=>$disbursementId
    ]) ?>

</div>
  </div>
</div>