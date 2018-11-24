<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\ClusterProgrammeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cluster Programmes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-programme-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Cluster Programme', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cluster_programme_id',
            'academic_year_id',
            'cluster_definition_id',
            'sub_cluster_definition_id',
            'programme_id',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
