<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AdmissionStudent */

$this->title = $model->admission_student_id;
$this->params['breadcrumbs'][] = ['label' => 'Admission Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admission-student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->admission_student_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->admission_student_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'admission_student_id',
            'admission_batch_id',
            'f4indexno',
            'programme_id',
            'has_transfered',
            'firstname',
            'middlename',
            'surname',
            'gender',
            'f6indexno',
            'points',
            'course_code',
            'course_description:ntext',
            'institution_code',
            'course_status',
            'entry',
            'study_year',
            'admission_no',
            'academic_year_id',
            'admission_status',
            'transfer_date',
        ],
    ]) ?>

</div>
