<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

$this->title = Yii::t('app', 'Approve  {modelClass}: ', [
    'modelClass' => 'Allocation Batch',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batch'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Return ", 'url' => ['view', 'id' => $model->allocation_batch_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Approve');
?>
<div class="allocation-batch-update">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_formapprove', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
