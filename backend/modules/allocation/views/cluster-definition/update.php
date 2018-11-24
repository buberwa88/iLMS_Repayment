<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterDefinition */

$this->title = 'Update Cluster : ';
$this->params['breadcrumbs'][] = ['label' => 'Cluster ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "View Details", 'url' => ['view', 'id' => $model->cluster_definition_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cluster-definition-update">
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