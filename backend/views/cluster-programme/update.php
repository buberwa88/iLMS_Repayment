<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterProgramme */

$this->title = 'Update Cluster Programme: ' . $model->cluster_programme_id;
$this->params['breadcrumbs'][] = ['label' => 'Cluster Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cluster_programme_id, 'url' => ['view', 'id' => $model->cluster_programme_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cluster-programme-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
