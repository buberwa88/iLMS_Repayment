<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Allocation Batch',
]) . $model->allocation_batch_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_batch_id, 'url' => ['view', 'id' => $model->allocation_batch_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="allocation-batch-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
