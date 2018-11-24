<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterProgramme */

$this->title = 'Create Cluster Programme';
$this->params['breadcrumbs'][] = ['label' => 'Cluster Programmes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-programme-create">
 <div class="panel panel-info">
        <div class="panel-heading">
<?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
        'cluster_id'=>$cluster_id,
         'ClusterProgramme' => $ClusterProgramme,   
    ]) ?>

</div>
 </div>
</div>