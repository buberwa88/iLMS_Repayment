<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\PayoutlistMovementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payoutlist Movements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payoutlist-movement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Payoutlist Movement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'movement_id',
            'disbursements_batch_id',
            'from_officer',
            'to_officer',
            'movement_status',
            // 'date_in',
            // 'date_out',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
