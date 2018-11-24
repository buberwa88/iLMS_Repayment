<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\VerificationAssignment */

$this->title = 'Update Verification Assignment: ' . $model->verification_assignment_id;
$this->params['breadcrumbs'][] = ['label' => 'Verification Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->verification_assignment_id, 'url' => ['view', 'id' => $model->verification_assignment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="verification-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
