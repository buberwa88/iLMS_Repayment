<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ClusterDefinition */

$this->title = 'Create Cluster';
$this->params['breadcrumbs'][] = ['label' => 'Cluster ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-definition-create">
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