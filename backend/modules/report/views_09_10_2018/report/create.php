<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\Report */

$this->title = 'Configure New Report';
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-create">
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
