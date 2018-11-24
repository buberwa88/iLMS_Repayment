<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SubCluster */

$this->title = 'Update Sub Cluster: ';
$this->params['breadcrumbs'][] = ['label' => 'Sub Clusters', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->sub_cluster_definition_id, 'url' => ['view', 'id' => $model->sub_cluster_definition_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sub-cluster-update">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
