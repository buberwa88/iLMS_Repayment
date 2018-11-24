<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementUserTask */

$this->title = 'Disbursement User Task';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement User Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-user-task-create">
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