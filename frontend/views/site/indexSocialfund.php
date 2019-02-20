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
if($refundTypeId==3){
    $title="Step 7: Social Fund Details";
    if(count($resultsCheckResultsGeneral->letter_family_session_document)==0){
      $link="site/create-familysessiondetails";
    }
    if(count($resultsCheckResultsGeneral->letter_family_session_document)>0){
        $link="site/index-familysessiondetails";
    }
}else{
    $title="Step 6: Social Fund Details";
}
//end set session

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
                                'label' => 'Employment Status',
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
                                'label'=>'Social security fund document',
                                'visible'=>$model->social_fund_status ==1 && $model->soccialFundDocument==1,
                                'value'=>call_user_func(function ($data) {
                                    if($data->social_fund_document !=''){
                                        return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->social_fund_document . '")','class'=>'label label-primary']);
                                    }else{
                                        return $data->social_fund_document;
                                    }
                                }, $model),
                                'format' => 'raw',

                            ],
                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>'Receipt document',
                                'visible'=>$model->social_fund_status ==1 && $model->soccialFundDocument==1,
                'value'=>call_user_func(function ($data) {
                    if($data->social_fund_receipt_document !=''){
                        return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->social_fund_receipt_document . '")','class'=>'label label-primary']);
                    }else{
                        return $data->social_fund_receipt_document;
                    }
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
                <?php if($refundTypeId==3){
                  ?>
                    <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",[$link]);?></div>
                    <?php
                }else{ ?>
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/refund-applicationview','refundApplicationID' => $refund_application_id]);?></div>
                <?php } ?>
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