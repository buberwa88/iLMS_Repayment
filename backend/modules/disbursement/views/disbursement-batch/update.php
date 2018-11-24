<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementBatch */

$this->title = 'Update Disbursement Batch: ';
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Batch', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->disbursement_batch_id, 'url' => ['view', 'id' => $model->disbursement_batch_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-batch-update">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
