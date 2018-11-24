<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementTask */

$this->title = 'Update Disbursement Task: ' . $model->disbursement_task_id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->disbursement_task_id, 'url' => ['view', 'id' => $model->disbursement_task_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
