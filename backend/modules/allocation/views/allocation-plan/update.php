<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlan */

$this->title = 'Update Allocation Framework';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Frameworks', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="learning-institution-fee-create">
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

