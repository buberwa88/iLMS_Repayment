<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportFilterSetting */

$this->title = 'Create Report Filter Setting';
$this->params['breadcrumbs'][] = ['label' => 'Report Filter Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-filter-setting-create">
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
