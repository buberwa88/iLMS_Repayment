<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\PopularReport */

$this->title = 'Create Popular Report';
$this->params['breadcrumbs'][] = ['label' => 'Popular Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="popular-report-create">
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
