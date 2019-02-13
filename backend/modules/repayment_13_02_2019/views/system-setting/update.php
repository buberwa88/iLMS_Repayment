<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\SystemSetting */

$this->title = 'Update System Setting';
$this->params['breadcrumbs'][] = ['label' => 'System Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->system_setting_id, 'url' => ['view', 'id' => $model->system_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-setting-update">
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
