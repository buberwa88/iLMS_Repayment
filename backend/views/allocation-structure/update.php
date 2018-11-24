<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationStructure */

$this->title = 'Update Allocation Structure: ' . ' ' . $model->allocation_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_structure_id, 'url' => ['view', 'id' => $model->allocation_structure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-structure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
