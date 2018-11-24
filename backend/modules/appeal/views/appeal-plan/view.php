<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\appeal\models\AppealPlan */

$this->title ='Appeal Plan Details';
$this->params['breadcrumbs'][] = ['label' => 'Appeal Plan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appeal-plan-view">
<div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        
        <div class="panel-body">
        <p>
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
        </p>
<?php 
    $gridColumn = [
       // 'appeal_plan_id',
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
 
<?php
if($providerAppealQuestion->totalCount){
    $gridColumnAppealQuestion = [
        ['class' => 'yii\grid\SerialColumn'],
            //'appeal_question_id',
                        [
                'attribute' => 'question.question',
                'label' => 'Question'
            ],
            [
                'attribute' => 'attachmentDefinition.attachment_desc',
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
</div>
