<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\PopularReport */

$this->title = 'Update Popular Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Popular Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="popular-report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
