<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationFrameworkSpecialGroup */

$this->title = 'Update Allocation Framework Special Group: ' . $model->special_group_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Framework Special Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->special_group_id, 'url' => ['view', 'id' => $model->special_group_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-framework-special-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
