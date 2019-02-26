<script type="text/javascript">
    function checkvalidation() {
        var rejection_narration = document.getElementById("rejection_narration_id").value.trim();
        //alert(autstandingAmount);
        if(rejection_narration !==''){
            return true;
        }else{
            var smsalert="Rejection reason can not be blank";
            alert (smsalert);
            return false;
        }
    }
</script>

<?php

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use backend\modules\repayment\models\RefundPaylist;
use yii\bootstrap\Modal;

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
                ?>
<!--                here for approval and rejection-->
            <?php
            if ($model->status == RefundPaylist::STATUS_CREATED && $model->hasPaylistItems()) {
                ?>
                <?=
                Html::a('Approve & Submit', ['paylistapproval', 'id' => $model->refund_paylist_id], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Are you sure you want to approve & submit the pay list?',
                        'method' => 'post',
                    ],
                ]);
            }
            ?>

  <?php
                Modal::begin([
                    'header' => '<h4>Reject the Pay list</h4>',
                    'toggleButton' =>   ['label' => 'Reject', 'style'=>'margin-left:4px', 'class' => 'btn btn-danger'],
                ]);
            ?>
                <?= Html::beginForm("index.php?r=repayment/refund-paylist/paylistapproval"); ?>
            <label>Pay list #:<?php echo " ".$model->paylist_number; ?></label>
            <br/><br/>
                    <label>Rejection Reason:</label>
                <?=
                Html::textArea('rejection_narration', null, ['size'=>20,'rows'=>4,'cols'=>50,'class'=>'form-control','id'=>'rejection_narration_id','options'=>['size'=>'20']])
                ?>
            <?=Html::hiddenInput('refund_paylist_id', $model->refund_paylist_id,['class'=>'form-control'])?>
            <?=Html::hiddenInput('current_level', $model->current_level,['class'=>'form-control'])?>
                <br/>
                <div class="text-right" >
                    <?php //if($model->hasErrors()){ ?>
                    <?= Html::submitButton('Reject', ['class'=>'btn btn-primary','onclick'=>'return  checkvalidation()']) ?>
                    <?php //} ?>
                    <?php
                    echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
                    echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/repayment/refund-paylist/view','id'=>$model->refund_paylist_id], ['class' => 'btn btn-warning']);
                    ?>
                </div>
                <?= Html::endForm(); ?>
            <?php
            Modal::end();

            ?>
<!--                end for approval and rejection-->


        <?php
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

            <p style="font-weight: bold">APPROVAL STATUS</p>
            <?= GridView::widget([
                'dataProvider' => $dataProviderPaylistOperation,
                //'filterModel' => $searchModelPaylistOperation,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'previous_internal_operational_id',
                        'label' => 'From Level',
                        'value' => function($model) {
                            return $model->previousInternalOperational->name;
                        }
                    ],
                    [
                        'attribute' => 'refund_internal_operational_id',
                        'label' => 'To Level',
                        'value' => function($model) {
                            return $model->refundInternalOperational->name;
                        }
                    ],
                    [
                        'attribute' => 'narration',
                        'label' => 'Comment',
                        'value' => function($model) {
                            return $model->narration;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status',
                        'value' => function($model) {
                            if($model->status==1){
                                return   "Recommended for approval";
                            }else if($model->status==2){
                                return "Rejected";
                            }else if($model->status==3){
                                return "Approved";
                            }
                        }
                    ],
                ],
            ]); ?>

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

