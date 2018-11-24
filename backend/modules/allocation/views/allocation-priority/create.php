<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPriority */

$this->title = 'Create Allocation Priority';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Priorities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-priority-create">
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
