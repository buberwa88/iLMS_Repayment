<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ReportCategory */

$this->title = 'Create Report Category';
$this->params['breadcrumbs'][] = ['label' => 'Report Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
