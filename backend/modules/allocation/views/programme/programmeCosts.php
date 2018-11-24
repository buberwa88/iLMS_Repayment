<?php

use backend\modules\allocation\models\AllocationHistory;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
?>
<?php
$this->title = 'View and Search Programme Costs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cluster-definition-view">
    <div class="programme-index">
        <div class="panel panel-info">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div style="margin: 1%;margin-left: 2%;clear: both;padding: 1%;width: 80%;">
                <?php
                echo $this->render('_search_costs', [
                    'model' => $model,
                ]);
                ?>
            </div>
            <div class="panel-body">


                <?php
                if ($dataProvider) {
                    $gridColumns = [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        [
                            'attribute' => 'learning_institution_id',
                            'vAlign' => 'middle',
                            'value' => function ($model) {
                                return $model->programme->learningInstitution->institution_name;
                            },
                            'vAlign' => 'middle',
                            'hAlign' => 'left',
                        ],
                        [
                            'attribute' => 'programme_name',
                            'vAlign' => 'middle',
                            'hAlign' => 'left',
                            'value' => 'programme.programme_name',
                        ],
                        [
                            'attribute' => 'academic_year',
                            'vAlign' => 'middle',
                            'hAlign' => 'left',
                            'value' => function($model) {
                                return \common\models\AcademicYear::getNameById($model->academic_year_id);
                            },
                        ],
                        [
                            'attribute' => 'programme_group_id',
                            'value' => function($model) {
                                return backend\modules\allocation\models\ProgrammeGroup::getGroupNameByID($model->programme->programme_group_id);
                            },
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                        ],
                        [
                            'attribute' => 'year_of_study',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value' => function($model) {
                                return $model->year_of_study;
                            },
                        ],
                        [
                            'attribute' => 'total_programme_cost',
                            'label' => 'Programme Cost',
                            'vAlign' => 'middle',
                            'hAlign' => 'center',
                            'value' => function($model) {
                                return \backend\modules\allocation\models\ProgrammeCost::getProgrammeCostByProgrammeID($model->programme_id, $model->academic_year_id);
                            },
                        ],
//                        ['class' => 'yii\grid\ActionColumn'],
                    ];
                    ////showing th cport menu only whem batch is approved for review
                    ///Batch Loading to minimize prevent load time
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
                        'fontAwesome' => true,
//            'asDropdown' => false
                        'batchSize' => 30,
                        'target' => '_blank',
                        'selectedColumns' => [0, 1, 2, 3, 4, 5,6,7], // Col seq 2 to 6
                        'columnSelectorOptions' => [
                            'label' => 'Export Columns',
                        ],
                        'hiddenColumns' => [6], // SerialColumn, Color, & ActionColumn
                        'disabledColumns' => [0, 1, 2, 3, 4, 5, 6,7], // ID & Name
                        'noExportColumns' => [8],
                        'dropdownOptions' => [
                            'label' => 'Export Data',
                            'class' => 'btn btn-default'
                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_EXCEL => false,
                            ExportMenu::FORMAT_EXCEL_X => false,
                            ExportMenu::FORMAT_TEXT => false,
                        ],
                            //'folder' => '@webroot/tmp', // this is default save folder on server
                    ]) . "<hr>\n";

                    // You can choose to render your own GridView separately
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $model,
                        'columns' => $gridColumns,
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</div>