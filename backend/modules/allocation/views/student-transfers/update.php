<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentTransfers */

$this->title = 'Update Student Transfers: ' . $model->student_transfer_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->student_transfer_id, 'url' => ['view', 'id' => $model->student_transfer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sector-definition-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>
