<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerMonthlyPenaltySetting */

$this->title = 'Update Employer Monthly Penalty Setting: ' . $model->employer_mnthly_penalty_setting_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Monthly Penalty Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employer_mnthly_penalty_setting_id, 'url' => ['view', 'id' => $model->employer_mnthly_penalty_setting_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-monthly-penalty-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
