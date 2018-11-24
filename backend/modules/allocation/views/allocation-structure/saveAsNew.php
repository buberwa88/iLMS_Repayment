<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructure */

$this->title = 'Save As New Allocation Structure: '. ' ' . $model->allocation_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_structure_id, 'url' => ['view', 'id' => $model->allocation_structure_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="allocation-structure-create">
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