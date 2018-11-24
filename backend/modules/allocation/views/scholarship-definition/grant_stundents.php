<div class="scholarship-student-index">
    <!--    <h4>Grant / Scholarship Students</h4>-->
    <p>
        <?php if ($model->is_active != backend\modules\allocation\models\ScholarshipDefinition::STATUS_INACTIVE) { ?>
            <?= \yii\bootstrap\Html::a('Add Student', ['/allocation/scholarship-definition/add-student', 'id' => $model->scholarship_id], ['class' => 'btn btn-success']) ?>
        <?php } ?>

        <?=
        \yii\bootstrap\Html::a('Copy Existing Student Into New Academic Year', ['/allocation/scholarship-definition/clone-student', 'id' => $model->scholarship_id], ['class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Are you sure you want to Copy Students from One Academic Year Into another?',
                'method' => 'post',
            ],]
        )
        ?>
    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_student,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'student_admission_no',
            [
                'attribute' => 'academic_year_id',
                'value' => 'academicYear.academic_year',
            ],
            'student_f4indexno',
            'student_f6indexno',
            'student_firstname',
            'student_lastname',
            'student_middlenames',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
