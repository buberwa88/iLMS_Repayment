<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportAccess */

$this->title = 'Create Report Access';
$this->params['breadcrumbs'][] = ['label' => 'Report Accesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-access-create">
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
