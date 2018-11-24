
<div class="scholarship-learning-institution-index">
    <!--<h4>Learning Institutions</h4>-->
    <p>
        <?= \yii\bootstrap\Html::a('Add Programme', ['/allocation/scholarship-definition/add-programme', 'id' => $model->scholarship_id], ['class' => 'btn btn-success']) ?>
        <?=
        \yii\bootstrap\Html::a('Copy Existing Programme into New Academic Year', ['/allocation/scholarship-definition/clone-programme', 'id' => $model->scholarship_id], ['class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Are you sure you want to Copy Programmes from One Academic Year Into another?',
                'method' => 'post',
            ],]
        )
        ?>
    </p>
    <?=
    \kartik\grid\GridView::widget([
        'dataProvider' => $model_programme,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'academicYear.academic_year',
            'programme.programme_name',
            'created_at',
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
