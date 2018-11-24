<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\allocation\models\AllocationBudget */

$this->title = 'Allocation Budget Details #' . $model->allocation_budget_id;
$this->params['breadcrumbs'][] = ['label' => 'Allocation Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learning-institution-fee-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->allocation_budget_id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->allocation_budget_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
                <?=
                Html::a('Go Back', ['index'], [
                    'class' => 'btn btn-success',
                ])
                ?>
            </p>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'academicYear.academic_year',
                    'applicant_category',
                    [
                        'attribute' => 'study_level',
                        'header' => 'Level ofStudy',
                        'value' => $model->studyLevel->applicant_category,
                    ],
                    [
                        'attribute' => 'place_of_study',
                        'header' => 'Place of Study',
                        'value' => $model->getPlaceOfStudy()
                    ],
                    [
                        'attribute' => 'budget_scope',
                        'header' => 'Budget Scope',
                        'value' => $model->getScopeName()
                    ],
                    [
                        'attribute' => 'budget_amount',
                        'value' => number_format($model->budget_amount, 2)
                    ],
                    [
                        'attribute' => 'is_active',
                        'value' => $model->getStatusName()
                    ],
                ],
            ])
            ?>

        </div>
    </div>
</div>
