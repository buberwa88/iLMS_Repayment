<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealPlan */

$this->title = $model->appeal_plan_id;
$this->params['breadcrumbs'][] = ['label' => 'Appeal Plan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-plan-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= 'Appeal Plan'.' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <?= Html::a('Save As New', ['save-as-new', 'id' => $model->appeal_plan_id], ['class' => 'btn btn-info']) ?>            
            <?= Html::a('Update', ['update', 'id' => $model->appeal_plan_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->appeal_plan_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'appeal_plan_id',
        [
            'attribute' => 'academicYear.academic_year',
            'label' => 'Academic Year',
        ],
        'appeal_plan_title',
        'appeal_plan_desc',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
    <div class="row">
        <h4>AcademicYear<?= ' '. Html::encode($this->title) ?></h4>
    </div>
    <?php 
    $gridColumnAcademicYear = [
        'academic_year',
        'is_current',
        'closed_date',
        'closed_by',
    ];
    echo DetailView::widget([
        'model' => $model->academicYear,
        'attributes' => $gridColumnAcademicYear    ]);
    ?>
    
    <div class="row">
<?php
if($providerAppealQuestion->totalCount){
    $gridColumnAppealQuestion = [
        ['class' => 'yii\grid\SerialColumn'],
            'appeal_question_id',
                        [
                'attribute' => 'question.question',
                'label' => 'Question'
            ],
            [
                'attribute' => 'attachmentDefinition.attachment_definition_id',
                'label' => 'Attachment Definition'
            ],
    ];
    echo Gridview::widget([
        'dataProvider' => $providerAppealQuestion,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-appeal-question']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode('Appeal Question'),
        ],
        'export' => false,
        'columns' => $gridColumnAppealQuestion
    ]);
}
?>

    </div>
</div>
