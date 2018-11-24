<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementUserStructureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement User Structures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-user-structure-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Disbursement User Structure', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'disbursement_user_structure_id',
            'disbursement_structure_id',
            'user_id',
            'created_at',
            'updated_at',
            // 'created_by',
            // 'updated_by',
            // 'deleted_by',
            // 'deleted_at',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
