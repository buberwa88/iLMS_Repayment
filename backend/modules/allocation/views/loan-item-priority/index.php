<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationSettingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Item Priority';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-setting-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Create Loan Item  Priority', ['create'], ['class' => 'btn btn-success']) ?>
                <?=
                \yii\bootstrap\Html::a('Clone Loan Items Priority', ['/allocation/loan-item-priority/clone', 'id' => $model->allocation_plan_id], ['class' => 'btn btn-warning',
                    'data' => [
                        'confirm' => 'Are you sure you want to Perform this operation?',
                        'method' => 'post',
                    ],]
                );
                ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //  'allocation_setting_id',
                    [
                        'attribute' => 'academic_year_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => function ($model) {
                            return $model->academicYear->academic_year;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\common\models\AcademicYear::find()->where(['in', 'is_current', [0, 1]])->asArray()->all(), 'academic_year_id', 'academic_year'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    'loan_item_category',
                    [
                        'attribute' => 'study_level',
                        'value' => 'studyLevel.applicant_category',
                    ],
                    [
                        'attribute' => 'loan_item_id',
                        'vAlign' => 'middle',
                        'width' => '200px',
                        'value' => 'loanItem.item_name',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\backend\modules\allocation\models\LoanItem::find()->where("is_active=1")->asArray()->all(), 'loan_item_id', 'item_name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'Search '],
                        'format' => 'raw'
                    ],
                    'priority_order',
                    'loan_award_percentage',
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}{delete}'],
                ],
                'hover' => true,
                'condensed' => true,
                    //'floatHeader' => true,
            ]);
            ?>
        </div>
    </div>
</div>