<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\SubCluster */

$this->title = 'Create Sub Cluster Definition';
$this->params['breadcrumbs'][] = ['label' => 'Sub Cluster', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-cluster-create">
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
