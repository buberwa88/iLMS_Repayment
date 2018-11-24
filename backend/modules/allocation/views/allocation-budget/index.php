<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\allocation\models\AllocationBudgetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Allocation Budgets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-fee-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">

            <p>
                <?= Html::a('Create/Add Budget', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'academic_year_id',
                        'header' => 'Academic Year',
                        'value' => 'academicYear.academic_year',
                    ],
                    'applicant_category',
                    [
                        'attribute' => 'study_level',
                        'header' => 'Level ofStudy',
                        'value' => 'studyLevel.applicant_category',
                    ],
                    [
                        'attribute' => 'place_of_study',
                        'header' => 'Place of Study',
                        'value' => function($model) {
                            return $model->getPlaceOfStudy();
                        },
                    ],
                    [
                        'attribute' => 'budget_scope',
                        'header' => 'Budget Scope',
                        'value' => function($model) {
                            return $model->getScopeName();
                        },
                    ],
                    [
                        'attribute' => 'budget_amount',
                        'value' => function($model) {
                            return number_format($model->budget_amount, 2);
                        },
                    ],
                    [
                        'attribute' => 'is_active',
                        'value' => function($model) {
                            return$model->getStatusName();
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
</div>