<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealPlan */

$this->title = 'Save As New Appeal Plan: '. ' ' . $model->appeal_plan_id;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Plan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->appeal_plan_id, 'url' => ['view', 'id' => $model->appeal_plan_id]];
$this->params['breadcrumbs'][] = 'Save As New';
?>
<div class="appeal-plan-create">
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