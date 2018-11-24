<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportAccess */

$this->title = 'Update Report Access: ' . $model->report_access_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Accesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->report_access_id, 'url' => ['view', 'id' => $model->report_access_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-access-update">
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
