<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentExamResult */

//$this->title = $model->student_exam_result_id;
//$this->params['breadcrumbs'][] = ['label' => 'Student Exam Results', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-exam-result-view">
 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'student_exam_result_id',
            'registration_number',
            'f4indexno',
            'academic_year_id',
            'programme_id',
            'study_year',
            'exam_status_id',
            'semester',
//            'confirmed',
//            'created_at',
//            'created_by',
//            'updated_at',
//            'updated_by',
        ],
    ]) ?>

</div>
