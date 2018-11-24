<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ScholarshipProgrammeLoanItem */

$this->title = 'Update Scholarship Programme Loan Item: ' . $model->scholarships_id;
$this->params['breadcrumbs'][] = ['label' => 'Scholarship Programme Loan Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->scholarships_id, 'url' => ['view', 'scholarships_id' => $model->scholarships_id, 'programme_id' => $model->programme_id, 'loan_item_id' => $model->loan_item_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scholarship-programme-loan-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
