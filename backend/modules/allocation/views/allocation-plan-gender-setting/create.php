<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlanGenderSetting */

$this->title = 'Create Allocation Plan Gender';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plan Gender', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-plan-gender-setting-create">
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
