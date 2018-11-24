<?php

use backend\modules\allocation\models\AllocationHistory;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
?>
<div class="allocation-plan-student-index" style="overflow: scroll;margin: 0.1%">
    <!--<h1>Student Allocated Loan</h1>-->
    <?php
    $gridColumns = [
        [
            'class' => 'kartik\grid\SerialColumn',
            'hAlign' => GridView::ALIGN_CENTER,
        ],
        [
            'attribute' => 'student_fname',
            'vAlign' => 'middle',
            'hAlign' => 'left',
            'value' => 'student_fname',
        ],
        [
            'attribute' => 'student_mname',
            'vAlign' => 'middle',
            'hAlign' => 'left',
            'value' => 'student_mname',
        ],
        [
            'attribute' => 'student_lname',
            'vAlign' => 'middle',
            'hAlign' => 'left',
            'value' => 'student_lname',
        ],
        [
            'attribute' => 'study_year',
            'label' => 'YoS',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'value' => 'study_year',
        ],
        [
            'attribute' => 'student_hli',
            'label' => 'University/College',
            'vAlign' => 'middle',
            'hAlign' => 'left',
            'value' => 'programme.learningInstitution.institution_code',
        ],
        [
            'attribute' => 'programme_id',
            'label' => 'Programme',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'value' => 'programme.programme_code',
        ],
        [
            'attribute' => 'student_fee_factor',
            'label' => 'Fee Factor',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'format' => ['decimal', 2],
            'value' => 'student_fee_factor',
        ],
        [
            'attribute' => 'student_myfactor',
            'label' => 'My Factor',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            'format' => ['decimal', 2],
            'value' => 'student_myfactor',
        ],
        [
            'attribute' => 'programme_cost',
            'vAlign' => 'middle',
            'hAlign' => 'right',
//            'format'=>['thousands',','],
            'value' => 'programme_cost',
        ],
        [
            'attribute' => 'student_ability',
            'label' => 'Ability',
            'vAlign' => 'middle',
            'hAlign' => 'right',
            'value' => 'student_ability',
        ],
        [
            'attribute' => 'needness_amount',
            'label' => 'Needness',
            'vAlign' => 'middle',
            'hAlign' => 'right',
            'value' => 'needness_amount',
        ],
        [
            'attribute' => 'total_allocated_amount',
            'label' => 'Allocated Loan',
            'vAlign' => 'middle',
            'hAlign' => 'right',
            'value' => 'total_allocated_amount',
        ],
        [
            'attribute' => 'allocation_type',
            'vAlign' => 'middle',
            'hAlign' => 'right',
        ],
        [
            'attribute' => 'comment',
            'vAlign' => 'middle',
            'hAlign' => 'left',
        ],
       // ['class' => 'yii\grid\ActionColumn'],
    ];
    ////showing th cport menu only whem batch is approved for review
    if ($model->status == AllocationHistory::STATUS_REVIEWED OR $model->status == AllocationHistory::STATUS_APPROVED) {
        ///Batch Loading to minimize prevent load time
        echo ExportMenu::widget([
            'dataProvider' => $model_students,
            'columns' => $gridColumns,
            'fontAwesome' => true,
//            'asDropdown' => false
            'batchSize' => 50,
            'target' => '_blank',
            'selectedColumns' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14], // Col seq 2 to 6
            'columnSelectorOptions' => [
                'label' => 'Export Columns',
            ],
            'hiddenColumns' => [15], // SerialColumn, Color, & ActionColumn
            'disabledColumns' => [0, 1, 2, 3, 4, 5, 6, 9, 12], // ID & Name
            'noExportColumns' => [15],
            'dropdownOptions' => [
                'label' => 'Export Data',
                'class' => 'btn btn-default'
            ],
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_EXCEL_X => false,
            ],
                //'folder' => '@webroot/tmp', // this is default save folder on server
        ]) . "<hr>\n";
    }
    // You can choose to render your own GridView separately
    echo GridView::widget([
        'dataProvider' => $model_students,
//        'filterModel' => $model_students,
        'columns' => $gridColumns,
    ]);
    ?>
</div>
