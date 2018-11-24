<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SubCluster */

$this->title = $model->sub_cluster_definition_id;
$this->params['breadcrumbs'][] = ['label' => 'Sub Clusters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-cluster-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->sub_cluster_definition_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->sub_cluster_definition_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'sub_cluster_definition_id',
            'sub_cluster_name',
            'sub_cluster_desc',
        ],
    ]) ?>

</div>
