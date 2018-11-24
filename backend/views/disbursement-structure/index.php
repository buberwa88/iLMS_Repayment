<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\disbursement\models\DisbursementStructureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disbursement Structures';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-structure-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Disbursement Structure', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'disbursement_structure_id',
            'structure_name',
            'parent_id',
            'order_level',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
