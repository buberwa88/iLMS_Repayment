<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportFilterSetting */

$this->title = 'Update Report Filter Setting';
$this->params['breadcrumbs'][] = ['label' => 'Report Filter Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->report_filter_setting_id, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-filter-setting-update">
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
