<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\StudentExamResult */

$this->title = $model->student_exam_result_id;
$this->params['breadcrumbs'][] = ['label' => 'Student Exam Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-exam-result-view">


    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'registration_number',
            'f4indexno',
            'learningInstitution.institution_name',
            'academicYear.academic_year',
            'programme.programme_name',
            'study_year',
            'examStatus.status_desc',
            'semester',
            'status',
            'created_at',
            'created_by',
            'verified_at',
            'verified_by',
            'approved_at',
            'approved_by'
        ],
    ])
    ?>

</div>
