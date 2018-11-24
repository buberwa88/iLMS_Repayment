<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\allocation\models\AllocationBatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Allocation Batches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Allocation Batch'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'allocation_batch_id',
            'batch_number',
            'batch_desc',
            'academic_year_id',
            'available_budget',
            // 'is_approved',
            // 'approval_comment:ntext',
            // 'created_at',
            // 'created_by',
            // 'is_canceled',
            // 'cancel_comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
