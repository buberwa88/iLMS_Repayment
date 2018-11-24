<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanGenderSetting */

$this->title = 'Update Allocation Plan Gender';
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-plan-gender-setting-update">
<div class="panel panel-info">

            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">

    <?= $this->render('_form_gender_setting', [
        'gender_item' => $gender_item,'allocation_plan_id'=>$allocation_plan_id,
    ]) ?>

</div>
        </div>
    </div>
