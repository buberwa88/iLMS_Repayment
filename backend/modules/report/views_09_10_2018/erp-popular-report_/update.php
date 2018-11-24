<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\report\models\ErpPopularReport */

$this->title = 'Update Erp Popular Report: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Erp Popular Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="erp-popular-report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
