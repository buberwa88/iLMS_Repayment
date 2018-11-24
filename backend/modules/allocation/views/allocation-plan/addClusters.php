<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgramme */

$this->title = 'Cluster Setting';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Setttings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <?=
            $this->render('_form_add_cluster', [
                'model' => $model, 'cluster' => $cluster
            ])
            ?>
        </div>
    </div>
</div>
