<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationSetting */

$this->title = 'Update Allocation Setting: ';
$this->params['breadcrumbs'][] = ['label' => 'Allocation Settings', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->allocation_setting_id, 'url' => ['view', 'id' => $model->allocation_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="allocation-setting-update">
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
