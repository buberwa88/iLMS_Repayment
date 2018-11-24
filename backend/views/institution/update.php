<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentExamResult */

$this->title = 'Update Student Exam Result: ';
$this->params['breadcrumbs'][] = ['label' => 'Student Exam Results', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->student_exam_result_id, 'url' => ['view', 'id' => $model->student_exam_result_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-exam-result-update">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?=
            $this->render('_form_add_results', [
                'model' => $model,
            ])
            ?>

        </div>
    </div>
</div>