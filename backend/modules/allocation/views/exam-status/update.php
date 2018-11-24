<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\ExamStatus */

$this->title = 'Update Exam Status: ';
$this->params['breadcrumbs'][] = ['label' => 'Exam Status', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->exam_status_id, 'url' => ['view', 'id' => $model->exam_status_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="exam-status-update">
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