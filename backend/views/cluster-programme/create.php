<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterProgramme */

$this->title = 'Create Cluster Programme';
$this->params['breadcrumbs'][] = ['label' => 'Cluster Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-programme-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
