<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportCategory */

$this->title = 'Update Report Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Report Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
