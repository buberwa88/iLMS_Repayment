<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SystemSetting */

$this->title = 'Create System Setting';
$this->params['breadcrumbs'][] = ['label' => 'System Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-setting-create">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
