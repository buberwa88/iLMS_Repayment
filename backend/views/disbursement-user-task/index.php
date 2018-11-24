<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementUserTaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement User Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-user-task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Disbursement User Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'disbursement_user_task_id',
            'disbursement_structure_id',
            'user_id',
            'created_at',
            'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'deleted_by',
            // 'deleted_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
