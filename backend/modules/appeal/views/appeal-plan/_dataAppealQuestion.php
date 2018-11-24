<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->appealQuestions,
        'key' => 'appeal_question_id'
    ]);
    $gridColumns = [
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
        /*[
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'appeal-question'
        ],*/
    ];
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'containerOptions' => ['style' => 'overflow: auto'],
        'pjax' => true,
        'beforeHeader' => [
            [
                'options' => ['class' => 'skip-export']
            ]
        ],
        'export' => [
            'fontAwesome' => true
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'showPageSummary' => false,
        'persistResize' => false,
    ]);
