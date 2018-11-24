<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\FinancialYear */

$this->title = 'Update Financial Year: ' . $model->financial_year_id;
$this->params['breadcrumbs'][] = ['label' => 'Financial Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->financial_year_id, 'url' => ['view', 'id' => $model->financial_year_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="financial-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
