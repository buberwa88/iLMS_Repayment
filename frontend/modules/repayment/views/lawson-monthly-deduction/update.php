<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LawsonMonthlyDeduction */

$this->title = 'Update Lawson Monthly Deduction: ' . $model->lawson_monthly_deduction_id;
$this->params['breadcrumbs'][] = ['label' => 'Lawson Monthly Deductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->lawson_monthly_deduction_id, 'url' => ['view', 'id' => $model->lawson_monthly_deduction_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lawson-monthly-deduction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
