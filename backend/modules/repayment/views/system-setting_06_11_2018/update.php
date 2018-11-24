<?php

/* @var $this yii\web\View */
/* @var $model backend\models\SystemSetting */

$this->title = 'Update System Setting';
$this->params['breadcrumbs'][] = ['label' => 'System Settings', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->system_setting_id, 'url' => ['view', 'id' => $model->system_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="system-setting-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
