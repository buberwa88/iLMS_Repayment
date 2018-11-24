<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Allocation Batch',
]) . $model->allocation_batch_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batch'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->allocation_batch_id, 'url' => ['view', 'id' => $model->allocation_batch_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="allocation-batch-update">
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
