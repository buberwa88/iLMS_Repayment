<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovement */

$this->title = 'Update Payoutlist Movement: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Payoutlist Movements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "View ", 'url' => ['view', 'id' => $model->movement_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payoutlist-movement-update">
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