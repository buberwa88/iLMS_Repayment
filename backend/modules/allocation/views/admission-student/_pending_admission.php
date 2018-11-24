<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
?>
<p >
    <?= Html::beginForm(['admission-student/confirm-uploaded-students'], 'post'); ?>        

</p>

<?=
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        /*
          'admission_student_id',
          'admission_batch_id',
          'f4indexno',
          'programme_id',
          'has_transfered',
         * 
         */
        'firstname',
        //'middlename',
        'surname',
        'f4indexno',
        //'gender',
        //'f6indexno',
        //'admission_batch_id',
        [
            'attribute' => 'programme_id',
            'label' => 'Programme',
            'format' => 'raw',
            'value' => function($model) {
                return $model->programme->programme_name;
            },
        ],
        [
            'attribute' => 'institution_code',
            'label' => 'Institution',
            'format' => 'raw',
            'value' => function($model) {
                return $model->programme->learningInstitution->institution_name;
            },
        ],
        [
            'attribute' => 'programme_status',
            'label' => 'Programme Status',
            'format' => 'raw',
            'value' => function($model) {
                         
                return $model->programme_status==1?'<span class="label label-success">Match</span>':'<span class="label label-danger">MissMatch</span>';
            },
        ],
        [
            'attribute' => 'admission_status',
            'label' => 'Status',
            'format' => 'raw',
//                'vAlign' => 'middle',
//                'width' => ' ',
            'value' => function($model) {
                if (($model->admission_status == 1)) {
                    //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                    return '<span class="label label-info"> Confirmed ';
                }


                if (($model->admission_status == 0)) {
                    //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                    return '<span class="label label-danger"> Pending';
                }
                if (($model->admission_status == 2)) {
                    //return "<span class='glyphicon glyphicon-ok'></span>" ; 
                    return '<span class="label label-warning"> Deseased';
                }
            },
            'filter' => [1 => 'Confirmed', 0 => 'Pending', 2 => 'Deseased']
        ],
        ['class' => 'yii\grid\CheckboxColumn'],
        // 'points',
        // 'course_code',
        // 'course_description:ntext',
        // 'institution_code',
        // 'course_status',
        // 'entry',
        // 'study_year',
        // 'admission_no',
        // 'academic_year_id',
        // 'admission_status',
        // 'transfer_date',
       // ['class' => 'yii\grid\ActionColumn'],
    ],
    'hover' => true,
    'condensed' => true,
    'floatHeader' => true,
]);
?>
<div class="text-right">
<?= Html::submitButton('Confirm selected students', ['class' => 'btn btn-warning',]); ?>
</div>
    <?= Html::endForm(); ?>

