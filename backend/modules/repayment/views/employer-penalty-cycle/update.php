<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\repayment\models\EmployerPenaltyCycle */

$this->title = 'Update Employer Penalty Cycle: ' . $model->employer_penalty_cycle_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalty Cycles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employer_penalty_cycle_id, 'url' => ['view', 'id' => $model->employer_penalty_cycle_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-penalty-cycle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
