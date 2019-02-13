<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->refundVerificationFrameworkItems,
        'key' => 'refund_verification_framework_item_id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        //'refund_verification_framework_item_id',
        [
                'attribute' => 'attachmentDefinition.attachment_desc',
                'label' => 'Attachment '
            ],
        'verification_prompt',
        'status',
        'is_active',
        
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
