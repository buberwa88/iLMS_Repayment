<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationUserStructure */

$this->title = 'Save As New Allocation User Structure: '. ' ' . $model->allocation_user_structure_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation User Structure', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_user_structure_id, 'url' => ['view', 'id' => $model->allocation_user_structure_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="allocation-user-structure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
