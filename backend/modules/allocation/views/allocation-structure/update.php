<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructure */

$this->title = 'Update Allocation Structure: ';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>'Detail View', 'url' => ['view', 'id' => $model->allocation_structure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-structure-update">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title); ?>
        </div>
        <div class="panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>