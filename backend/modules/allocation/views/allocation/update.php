<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\Allocation */

$this->title = 'Update Allocation: ' . $model->allocation_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_id, 'url' => ['view', 'id' => $model->allocation_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
