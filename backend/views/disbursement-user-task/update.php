<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementUserTask */

$this->title = 'Update Disbursement User Task: ' . $model->disbursement_user_task_id;
$this->params['breadcrumbs'][] = ['label' => 'Disbursement User Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->disbursement_user_task_id, 'url' => ['view', 'id' => $model->disbursement_user_task_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="disbursement-user-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
