<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\EmployerPenalty */

$this->title = 'Update Employer Penalty: ' . $model->employer_penalty_id;
$this->params['breadcrumbs'][] = ['label' => 'Employer Penalties', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employer_penalty_id, 'url' => ['view', 'id' => $model->employer_penalty_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employer-penalty-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
