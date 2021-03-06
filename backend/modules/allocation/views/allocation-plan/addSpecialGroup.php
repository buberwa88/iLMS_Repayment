<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationPlan */

$this->title = 'Special Groups';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-fee-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php
            echo $this->render('_form_add_special_group', [
                'model' => $model, 'model_special_group' => $model_special_group
            ]);
            ?>

        </div>
    </div>
</div>
