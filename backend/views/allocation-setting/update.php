<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationSetting */

$this->title = 'Update Allocation Setting: ' . $model->allocation_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_setting_id, 'url' => ['view', 'id' => $model->allocation_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
