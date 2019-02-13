<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->refundApplications,
        'key' => 'refund_application_id'
    ]);
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'refund_application_id',
        [
                'attribute' => 'refundClaimant.refund_claimant_id',
                'label' => 'Refund Claimant'
            ],
        'application_number',
        'refund_claimant_amount',
        [
                'attribute' => 'finaccialYear.financial_year',
                'label' => 'Finaccial Year'
            ],
        [
                'attribute' => 'academicYear.academic_year',
                'label' => 'Academic Year'
            ],
        'trustee_firstname',
        'trustee_midlename',
        'trustee_surname',
        'trustee_phone_number',
        'trustee_email:email',
        'trustee_sex',
        'current_status',
        'check_number',
        'bank_account_number',
        'bank_account_name',
        [
                'attribute' => 'bank.bank_id',
                'label' => 'Bank'
            ],
        'refund_type_id',
        'liquidation_letter_number',
        'is_active',
        'submitted',
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'refund-application'
        ],
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
