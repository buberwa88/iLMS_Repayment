<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanGenderSetting */

$this->title = 'Update Allocation Plan Gender';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Gender', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->allocation_plan_gender_setting_id, 'url' => ['view', 'id' => $model->allocation_plan_gender_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-plan-gender-setting-update">
<div class="panel panel-info">

            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
        </div>
    </div>
