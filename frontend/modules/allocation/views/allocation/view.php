<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

$this->title = $model->allocation_batch_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->allocation_batch_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->allocation_batch_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'allocation_batch_id',
            'batch_number',
            'batch_desc',
            'academic_year_id',
            'available_budget',
            'is_approved',
            'approval_comment:ntext',
            'created_at',
            'created_by',
            'is_canceled',
            'cancel_comment:ntext',
        ],
    ]) ?>

</div>
