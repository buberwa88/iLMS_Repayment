<script>
    function viewUploadedFile(url) {
        $('#view-attachment-dialog-id').dialog('open');
        $('#view-attachment-iframe-id').attr('src', url);
    }
    function reloadPage(url) {
        document.location.href = url;
    }
</script>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\RefundClaimantEmployment;
use frontend\modules\repayment\models\RefundApplication;

//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
//end set session

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$resultsCheckCount = RefundApplication::getStageCheckedBankDetails($refund_application_id);
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$resultsCheckCountSocialFund = RefundApplication::getStageCheckedSocialFund($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
$educationAttained = $resultsCheckResultsGeneral->educationAttained;
$attachmentType=\backend\modules\repayment\models\RefundClaimantAttachment::Bank_Card;
$attachmentTypeDeedPoll=\backend\modules\repayment\models\RefundClaimantAttachment::Claimant_deed_pole_document;

if ($educationAttained == 2) {
    $step3 = 3;
    $step4 = 3;
    $step5 = 4;
    $step6 = 5;
    $step7 = 6;
} else if ($educationAttained == 1) {
    $step3 = 3;
    $step4 = 4;
    $step5 = 5;
    $step6 = 6;
    $step7 = 7;
} else {
    $step3 = 3;
    $step4 = 3;
    $step5 = 4;
    $step6 = 5;
    $step7 = 6;
}

if ($resultsCheckCount > 0) {
    $link = 'site/index-bankdetails';
}
if ($resultsCheckCount == 0) {
    $link = 'site/create-refund-bankdetails';
}
if ($refundTypeId == 3) {
    $title = "Step 5: Bank Details";
    if ($resultsCheckCountSocialFund == 0) {
        $link = 'site/create-securityfund';
    } else {
        $link = 'site/index-socialfund';
    }
} else if ($refundTypeId == 1) {
    $title = "Step " . $step5 . ": Bank Details";
    if ($resultsCheckCountSocialFund == 0) {
        $link = 'site/create-securityfund';
    } else {
        $link = 'site/index-socialfund';
    }
} else if ($refundTypeId == 2) {
    $title = "Step 4: Bank Details";
    if ($resultsCheckCountSocialFund == 0) {
        $link = 'site/create-securityfund';
    } else {
        $link = 'site/index-socialfund';
    }
}
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php
            $model = RefundApplication::findOne($refund_application_id);

            $attributes = [

                [
                    'columns' => [

                        [
                            'label' => 'Bank Name',
                            'value' => $model->bank_name,
                        ],
                    ],
                ],
                [
                    'columns' => [

                        [
                            'label' => 'Account Number',
                            'value' => $model->bank_account_number,
                        ],
                    ],
                ],
                [
                    'columns' => [

                        [
                            'label' => 'Account Name',
                            'value' => $model->bank_account_name,
                        ],
                    ],
                ],
                [
                    'columns' => [

                        [
                            'label' => 'Branch',
                            'value' => $model->branch,
                        ],
                    ],
                ],
                [
                    'columns' => [

                            /*
                        [
                            'label' => 'Bank Card Document',
                            'value' => call_user_func(function ($data) {
                                        if ($data->bank_card_document != '') {
                                            return yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->bank_card_document . '")', 'class' => 'label label-primary']);
                                        } else {
                                            return $data->bank_card_document;
                                        }
                                    }, $model),
                                    'format' => 'raw',
                                ],
                        */
                        [
                            'label' => 'Bank Card Document',
                            'value' => call_user_func(function ($data) use($attachmentType) {
                                return Html::a("VIEW", ['site/download', 'id'=>$data->refund_application_id,'attachmentType'=>$attachmentType]);
                            }, $model),
                            'format' => 'raw',
                        ],


                            ],
                        ],
                [
                    'columns' => [
                        [
                            'label' => 'Deed Poll Document',
                            'visible'=>$model->claimant_names_changed_status==1,
                            'value' => call_user_func(function ($data) use($attachmentTypeDeedPoll) {
                                return Html::a("VIEW", ['site/download', 'id'=>$data->refund_application_id,'attachmentType'=>$attachmentTypeDeedPoll]);
                            }, $model),
                            'format' => 'raw',
                        ],


                    ],
                ],
                    ];


                    echo DetailView::widget([
                        'model' => $model,
                        'condensed' => true,
                        'hover' => true,
                        'mode' => DetailView::MODE_VIEW,
                        'attributes' => $attributes,
                    ]);
                    echo '<div class="text-right"><p>';
                    ?>
                    <?= Html::a('Update/Edit Details', ['/site/update-bank-details', 'id' => $model->refund_application_id], ['class' => 'btn btn-primary']) ?>
                    <?php
                    echo "</p></div>";
                    ?>
                    <br/></br/>
                    <div class="rowQA">
                        <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK", ['site/refund-liststeps']); ?></div>
                        <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>", [$link]); ?></div>
                    </div>
                </div>
            </div>



            <?php
            /*
              yii\jui\Dialog::begin([
              'id' => 'view-attachment-dialog-id',
              'clientOptions' => [
              'width' => '500',
              'height' => '400',
              'modal' => true,
              'autoOpen' => false,
              ]
              ]);

              echo '<iframe src="" id="view-attachment-iframe-id" width="100%" height="100%" style="border: 0">';
              echo '</iframe>';
              echo '<br><br>';
              yii\jui\Dialog::end();
             */
            ?>