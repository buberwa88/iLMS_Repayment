
<div class="scholarship-learning-institution-index">
    <!--<h4>Learning Institutions</h4>-->
    <p>
        <?php if ($model->is_active != backend\modules\allocation\models\ScholarshipDefinition::STATUS_INACTIVE) { ?>

            <?= \yii\bootstrap\Html::a('Add Eligible Learning Institution', ['/allocation/scholarship-definition/add-institution', 'id' => $model->scholarship_id], ['class' => 'btn btn-success']) ?>

        <?php } ?>
        <?=
        \yii\bootstrap\Html::a('Copy Existing Into New Academic Year', ['/allocation/scholarship-definition/clone-institution', 'id' => $model->scholarship_id], ['class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Are you sure you want to Copy Institutions from One Academic Year Into another?',
                'method' => 'post',
            ],]
        );
        ?>

    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_learning_institution,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'academicYear.academic_year',
            'learningInstitution.institution_name',
            ['attribute' => 'is_active',
                'value' => function($model) {
                    return $model->getStatusNameByValue();
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
