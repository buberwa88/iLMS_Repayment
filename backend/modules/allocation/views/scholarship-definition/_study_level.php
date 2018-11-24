<p>
    <?php if ($model->is_active != backend\modules\allocation\models\ScholarshipDefinition::STATUS_INACTIVE) { ?>
        <?= \yii\bootstrap\Html::a('Add Study level', ['/allocation/scholarship-definition/add-study-level', 'id' => $model->scholarship_id], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    
    <?=
    \yii\bootstrap\Html::a('Copy Existing', ['/allocation/scholarship-definition/clone-study-level', 'id' => $model->scholarship_id], ['class' => 'btn btn-warning',
        'data' => [
            'confirm' => 'Are you sure you want to Copy Study Level from One Academic Year Into another?',
            'method' => 'post',
        ],]
    )
    ?>

</p>
<?=
\kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'applicant_category_id',
            'label' => 'Study Level',
            'value' => 'applicantCategory.applicant_category',
        ],
        [
            'attribute' => 'academic_year_id',
            'label' => 'Academic Year',
            'value' => 'academicYear.academic_year',
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
?>
