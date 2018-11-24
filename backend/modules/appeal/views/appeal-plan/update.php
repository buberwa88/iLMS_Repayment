<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealPlan */

$this->title = 'Update Appeal Plan: ';
$this->params['breadcrumbs'][] = ['label' => 'Appeal Plan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Details', 'url' => ['view', 'id' => $model->appeal_plan_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="appeal-plan-update">

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