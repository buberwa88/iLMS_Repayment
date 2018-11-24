<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructure */

$this->title = 'Save As New Assign Allocation Staff to Alllocation Structure: ';
$this->params['breadcrumbs'][] = ['label' => 'Allocation User Structure', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->allocation_user_structure_id, 'url' => ['view', 'id' => $model->allocation_user_structure_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="allocation-user-structure-create">
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