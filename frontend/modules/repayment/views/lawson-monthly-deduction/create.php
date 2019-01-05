<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\LawsonMonthlyDeduction */

$this->title = 'Create Lawson Monthly Deduction';
$this->params['breadcrumbs'][] = ['label' => 'Lawson Monthly Deductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lawson-monthly-deduction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
