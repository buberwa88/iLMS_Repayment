<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionBatch */
$this->title = 'Update Admission Batch: ' ;
$this->params['breadcrumbs'][] = ['label' => 'Admission Batch', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' =>"View Detail", 'url' => ['view', 'id' => $model->admission_batch_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admission-batch-update">
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
