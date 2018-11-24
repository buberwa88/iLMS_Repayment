<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructure */

$this->title = 'Update Allocation User Structure: ' . ' ' . $model->allocation_user_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation User Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_user_structure_id, 'url' => ['view', 'id' => $model->allocation_user_structure_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-user-structure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
