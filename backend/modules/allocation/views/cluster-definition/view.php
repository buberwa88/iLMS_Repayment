<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterDefinition */

$this->title = "Cluster Detail";
$this->params['breadcrumbs'][] = ['label' => 'Cluster', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-definition-view">
    <div class="panel panel-info">
        <div class="panel-heading">

        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->cluster_definition_id], ['class' => 'btn btn-primary']) ?>
                <?php
                if (!count($model->clusterProgrammes)) {
                    echo Html::a('Delete', ['delete', 'id' => $model->cluster_definition_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                }
                ?>
            </p>
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'cluster_name',
                    'cluster_desc',
                    'priority_order',
                    'is_active',
                ],
            ])
            ?>


        </div>
    </div>
</div>