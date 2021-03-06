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
//end set session

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refund_type_id = $resultsCheckResultsGeneral->refund_type_id;
$resultsCheckCount=RefundApplication::getStageCheckedBankDetails($refund_application_id);
if ($resultsCheckCount == 0) {
    $link='site/create-refund-bankdetails';
}
if ($resultsCheckCount > 0) {
    $link='site/index-bankdetails';
}
if($refund_type_id==2){
    $title="Step 3: Repayment Details";
}else{
    $title="Step 2: Repayment Details";
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
            <?php  $modelRefundApplication = RefundApplication::find()->where("refund_application_id={$refund_application_id}")->all();


            $sn = 0;
            foreach ($modelRefundApplication as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => 'Liquidation Number',
                                'value'=>$model->liquidation_letter_number,
                            ],

                        ],
                    ],

                    [
                        'columns' => [

                            [
                                'label'=>'Liquidation Letter Document',
                'value'=>call_user_func(function ($data) {
                    if($data->liquidation_letter_document !=''){
                        return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->liquidation_letter_document . '")','class'=>'label label-primary']);
                    }else{
                        return $data->liquidation_letter_document;
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
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",[$link]);?></div>
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