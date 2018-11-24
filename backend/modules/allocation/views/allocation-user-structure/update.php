<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructure */

$this->title = 'Update Assign Allocation Staff Structure: ';
$this->params['breadcrumbs'][] = ['label' => 'Allocation User Structure', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->allocation_user_structure_id, 'url' => ['view', 'id' => $model->allocation_user_structure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-user-structure-update">
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