<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationCustomCriteria */

$this->title = 'Update Verification Custom Criteria: ' . $model->verification_custom_criteria_id;
$this->params['breadcrumbs'][] = ['label' => 'Verification Custom Criterias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->verification_custom_criteria_id, 'url' => ['view', 'id' => $model->verification_custom_criteria_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="verification-custom-criteria-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
