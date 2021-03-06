<script>
    function viewUploadedFile(url) {
        $('#view-attachment-dialog-id').dialog('open');
        $('#view-attachment-iframe-id').attr('src', url);
    }
    function reloadPage(url){
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
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
$educationAttained=$resultsCheckResultsGeneral->educationAttained;
$Letter_from_social_security=\backend\modules\repayment\models\RefundClaimantAttachment::Letter_from_social_security;
$RECEIPT_FROM_SOCIAL_FUND=\backend\modules\repayment\models\RefundClaimantAttachment::RECEIPT_FROM_SOCIAL_FUND;
$action="index-socialfund";


//label sequences
if($educationAttained==2){
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}else if($educationAttained==1){
    $step3=3;$step4=4;$step5=5;$step6=6;$step7=7;
}else{
    $step3=3;$step4=3;$step5=4;$step6=5;$step7=6;
}

if($refundTypeId==3){
    $title="Step 6: Social Fund Details";
    $link="site/refund-applicationview";
}else if($refundTypeId==1){
    $title="Step ".$step6.": Social Fund Details";
    $link="site/refund-applicationview";
}else if($refundTypeId==2){
    $title="Step 5: Social Fund Details";
    $link="site/refund-applicationview";
}else{
    $title="Step 6: Social Fund Details";
}
//end label step sequence

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php  $modelRefundApplication = RefundApplication::find()->where("refund_application_id={$refund_application_id}")->all();


            $sn = 0;
            foreach ($modelRefundApplication as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => $model->refund_type_id ==3 ? "Deceased's Employment Status" : 'Employment Status',
                                'value'=>call_user_func(function ($data) {
                                    if($data->social_fund_status ==1){
                                        return  'Retired';
                                    }else{
                                        return 'Not Retired';
                                    }
                                }, $model),
                                'format' => 'raw',
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>$model->refund_type_id ==3 ? "Deceased's Social Security Fund Document":'Social security fund document',
                                'visible'=>$model->social_fund_status ==1 && $model->soccialFundDocument==1,
                                'value' => call_user_func(function ($data) use($Letter_from_social_security,$action) {
                                    return Html::a("VIEW", ['site/download', 'id'=>$data->refund_application_id,'attachmentType'=>$Letter_from_social_security,'action'=>$action]);
                                }, $model),
                                'format' => 'raw',

                            ],
                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>$model->refund_type_id ==3 ? "Deceased's Receipt Document":'Receipt document',
                                'visible'=>$model->social_fund_status ==1 && $model->soccialFundDocument==1,
                                'value' => call_user_func(function ($data) use($RECEIPT_FROM_SOCIAL_FUND,$action) {
                                    return Html::a("VIEW", ['site/download', 'id'=>$data->refund_application_id,'attachmentType'=>$RECEIPT_FROM_SOCIAL_FUND,'action'=>$action]);
                                }, $model),
                                'format' => 'raw',
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
                echo '<div class="text-right">
	<p>';
                ?>
                <?= Html::a('Update/Edit', ['update-contactperson', 'id' => '','emploID'=>''], ['class' => 'btn btn-primary']) ?>
                <?php
                echo "</p></div>";
            }?>
            <br/></br/>
            <div class="rowQA">
                <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/refund-liststeps']);?></div>
                <?php //if($refundTypeId==3){
                  ?>
                    <?php
                //}else{ ?>
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",[$link,'refundApplicationID' => $refund_application_id]);?></div>
                <?php //} ?>
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