<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterProgramme */

$this->title = 'Update Cluster Programme: ';
$this->params['breadcrumbs'][] = ['label' => 'Cluster Programmes', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->cluster_programme_id, 'url' => ['view', 'id' => $model->cluster_programme_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cluster-programme-update">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
 </div>
</div>