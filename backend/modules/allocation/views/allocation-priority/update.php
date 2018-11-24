<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPriority */

$this->title = 'Update Allocation Priority: ';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Priorities', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->allocation_priority_id, 'url' => ['view', 'id' => $model->allocation_priority_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-priority-update">
<div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>