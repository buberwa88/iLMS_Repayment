<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovement */

$this->title = 'Payout List';
$this->params['breadcrumbs'][] = ['label' => 'Payoutlist', 'url' => ['reviewall-disbursement']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payoutlist-movement-create">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_formall', [
        'model' => $model,
        'disbursementId'=>$disbursementId,
        'level'=>$level
    ]) ?>

</div>
  </div>
</div>