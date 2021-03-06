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
use frontend\modules\repayment\models\RefundContactPerson;
use frontend\modules\repayment\models\RefundApplication;

//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
//end set session

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$resultsCheckCountSocialFund = RefundApplication::getStageCheckedSocialFund($refund_application_id);
$resultsCheckCountEmploymentDetails = RefundClaimantEmployment::getStageChecked($refund_application_id);
$action='index-contactdetails';
$Claimant_refund_letter_document=\backend\modules\repayment\models\RefundClaimantAttachment::Claimant_refund_letter_document;
/*
if ($resultsCheckCountSocialFund > 0) {
    $link='site/index-socialfund';
}
if($resultsCheckCountSocialFund == 0) {
    $link='site/create-securityfund';
}
*/

$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
if($refundTypeId==3){
    $title="Step 1: Contacts Details";
    if ($resultsCheckResultsGeneral->educationAttained > 0) {
        $link = 'site/indexf4educationdetails';
    }else{
        $link = 'site/create-educationgeneral';
    }
}else if($refundTypeId==1){
    $title="Step 1: Contacts Details";
    if ($resultsCheckResultsGeneral->educationAttained > 0) {
        $link = 'site/indexf4educationdetails';
    }else{
        $link = 'site/create-educationgeneral';
    }
}else if($refundTypeId==2){
	$title="Step 1: Contacts Details";
    if($resultsCheckCountEmploymentDetails == 0) {
    $link = 'site/create-employment-details';
    }
    if ($resultsCheckCountEmploymentDetails > 0) {
        $link =  "site/index-employment-details";
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
            <?php  $modelRefundContctPerson = RefundContactPerson::find()->where("refund_application_id={$refund_application_id}")->all();


            $sn = 0;
            foreach ($modelRefundContctPerson as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => 'First Name',
                                'value'=>$model->firstname,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Middle Name',
                                'value'=>$model->middlename,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Last Name',
                                'value'=>$model->surname,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Phone Number',
                                'value'=>$model->phone_number,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Email',
                                'value'=>$model->email_address,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>'Refund Application Letter Document',
                                'value' => call_user_func(function ($data) use($refund_application_id,$Claimant_refund_letter_document,$action) {
                                    return Html::a("VIEW", ['site/download', 'id'=>$refund_application_id,'attachmentType'=>$Claimant_refund_letter_document,'action'=>$action]);
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
                <?= Html::a('Update/Edit Details', ['updatecontacts', 'id' =>$model->refund_contact_person_id], ['class' => 'btn btn-primary']) ?>
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