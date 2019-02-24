<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use backend\modules\repayment\models\RefundPaylist;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\repayment\models\RefundPaylistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Refund Pay list';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-paylist-view">

    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?php if ($model->status == RefundPaylist::STATUS_CREATED) { ?>
                    <?= Html::a('Update', ['update', 'id' => $model->refund_paylist_id], ['class' => 'btn btn-primary']) ?>
                    <?=
                    Html::a('Delete', ['delete', 'id' => $model->refund_paylist_id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ])
                    ?>
                    <?php
                }

                if ($model->status == RefundPaylist::STATUS_CREATED && $model->hasPaylistItems()) {
                    ?>
                    <?=
                    Html::a('Confirm & Sumbit for Approval', ['confirm-paylist', 'id' => $model->refund_paylist_id], [
                        'class' => 'btn btn-warning',
                        'data' => [
                            'confirm' => 'Are you sure you want to Confirm & Submit for Approval?',
                            'method' => 'post',
                        ],
                    ]);
                }


                ////submit button
                if ($model->status == RefundPaylist::STATUS_REVIEWED && $model->hasPaylistItems()) {
                    ?>
                    <?=
                    Html::a('Approve Paylist', ['approve-paylist', 'id' => $model->refund_paylist_id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Are you sure you want to Approve this Paylist?',
                            'method' => 'post',
                        ],
                    ]);
                }
                ?>
            </p>
            <?php
            if (Yii::$app->session->hasFlash('error')) {
                ?>
                <div class="error-summary"><?php echo Yii::$app->session->getFlash('error'); ?></div>
                <?php
            }
            ?>

            <?php
            if (Yii::$app->session->hasFlash('success')) {
                ?>
                <div class="success"><?php echo Yii::$app->session->getFlash('success'); ?></div>
                <?php
            }
            ?>

            <?=
            kartik\detail\DetailView::widget([
                'model' => $model,
                'attributes' => [
                    ['attribute' => 'paylist_number',
                        'label' => 'Pay list #'
                    ],
                    ['attribute' => 'paylist_name',
                        'label' => 'Name/Description #',
                        'value' => $model->paylist_name . ': ' . $model->paylist_description,
                        'format' => 'html'
                    ],
                    [
                        'attribute' => 'paylist_total_amount',
                        'value' => number_format(backend\modules\repayment\models\RefundPaylistDetails::getPayListTotalAmountById($model->refund_paylist_id)),
                    ], [
                        'attribute' => 'status',
                        'value' => strtoupper($model->getStatusName())
                    ],
                    [
                        'attribute' => 'date_created',
                        'value' => date('D, d-M-Y @ H:i:s', strtotime($model->date_created)),
                    ],
                ],
            ])
            ?>

            <p style="font-weight: bold">CLAIMANT LIST</p>
            <?=
            GridView::widget([
                'dataProvider' => $paylist_details_model->getPlayListDetails(),
//            'filterModel' => $paylist_details_model,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'refund_application_reference_number',
                        'label' => 'Application #',
                        'value' => function($model) {
                            return strtoupper($model->refund_application_reference_number);
                        },
                        'vAlign' => 'middle',
                    ],
                    [
                        'attribute' => 'claimant_name',
                        'label' => 'Claimant',
                        'value' => function($model) {
                            return strtoupper($model->claimant_name);
                        },
                        'vAlign' => 'left',
                    ],
                    'claimant_f4indexno',
                    [
                        'attribute' => 'refund_claimant_amount',
                        'label' => 'Amount',
                        'vAlign' => 'right',
                        'value' => function($model) {
                            return number_format($model->refund_claimant_amount);
                        },
                    ],
                    [
                        'attribute' => 'payment_bank_account_number',
                        'label' => 'Bank Account',
                        'value' => function($model) {
                            return $model->payment_bank_account_number;
                        }
                    ],
                    [
                        'attribute' => 'payment_bank_name',
                        'label' => 'Bank Name',
                        'value' => function($model) {
                            return $model->payment_bank_name . ' ' . (($model->payment_bank_branch) ? $model->payment_bank_branch : '');
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model) {
                            return $model->getStatusName();
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                        'visible' => ($model->status == RefundPaylist::STATUS_CREATED) ? TRUE : FALSE
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

