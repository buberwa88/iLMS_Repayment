<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SubCluster */

$this->title = 'Create Sub Cluster';
$this->params['breadcrumbs'][] = ['label' => 'Sub Clusters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-cluster-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
