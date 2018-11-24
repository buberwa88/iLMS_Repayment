<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\SubClusterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Clusters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-cluster-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sub Cluster', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sub_cluster_definition_id',
            'sub_cluster_name',
            'sub_cluster_desc',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
