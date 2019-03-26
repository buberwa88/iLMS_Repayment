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
use frontend\modules\repayment\models\RefundClaimant;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundClaimantEmployment;
//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$resultsCheckCountEmploymentDetails = RefundClaimantEmployment::getStageChecked($refund_application_id);
$attachmentTypef4cetificate=\backend\modules\repayment\models\RefundClaimantAttachment::F4_CERTIFICATE_DOCUMENT;
$Employer_letter_Document=\backend\modules\repayment\models\RefundClaimantAttachment::Employer_letter_Document;
$action='indexf4educationdetails';
//$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
//if($refundTypeId==3){
    //$title="Step 1: Deceased's Form 4 Education";
//}else{
    //$title="Step 1: Form 4 Education";
//}


//$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
if($refundTypeId==3){
    $title="Step 2: Deceased's Primary/Olevel Education";
    if(count($resultsCheckResultsGeneral->death_certificate_number)==0) {
        $link = 'site/create-deathdetails';
    }
    if(count($resultsCheckResultsGeneral->death_certificate_number)>0){
        $link = 'site/index-deathdetails';
    }
}else if($refundTypeId==1){
    $title="Step 2: Primary/Olevel Education";
    if ($resultsCheckResultsGeneral->educationAttained == 1) {
        $link = 'site/index-tertiary-education';
    }else{
        if ($resultsCheckCountEmploymentDetails == 0) {
            $link = 'site/create-employment-details';
        }else{
            $link = 'site/index-employment-details';
        }
    }
}else if($refundTypeId==2){
    $title="Step 2: Primary/Olevel Education";
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
            <?php  $modelRefundClaimant = RefundApplication::find()->where("refund_application_id={$refund_application_id}")->all();


            $sn = 0;
            foreach ($modelRefundClaimant as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => 'F4 Index #',
                                'visible'=>$model->educationAttained==1,
                                'value'=>$model->refundClaimant->f4indexno,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Completion Year',
                                'visible'=>$model->educationAttained==1,
                                'value'=>$model->refundClaimant->f4_completion_year,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'First Name',
                                'visible'=>$model->educationAttained==1,
                                'value'=>$model->refundClaimant->necta_firstname,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Middle Name',
                                'visible'=>$model->educationAttained==1,
                                'value'=>$model->refundClaimant->necta_middlename,
                            ],

                        ],
                    ],
                [
                    'columns' => [

                        [
                            'label' => 'Last Name',
                            'visible'=>$model->educationAttained==1,
                            'value'=>$model->refundClaimant->necta_surname,
                        ],

                    ],
                ],

                    [
                        'columns' => [
                          /*
                            [
                                'label'=>'F4 Certificate Document',
                                'visible'=>$model->educationAttained==1,
                'value'=>call_user_func(function ($data) {
                    if($data->refundClaimant->f4_certificate_document !=''){
                        return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->refundClaimant->f4_certificate_document . '")','class'=>'label label-primary']);
                    }else{
                        return $data->refundClaimant->f4_certificate_document;
                    }
                }, $model),
                'format' => 'raw',

                            ],
                          */
                            [
                                'label' => 'F4 Certificate Document',
                                'visible'=>$model->educationAttained==1 && $model->refundClaimant->f4type==2,
                                'value' => call_user_func(function ($data) use($attachmentTypef4cetificate) {
                                    return Html::a("VIEW", ['site/download', 'id'=>$data->refund_claimant_id,'attachmentType'=>$attachmentTypef4cetificate]);
                                }, $model),
                                'format' => 'raw',
                            ],
                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>'Employer Letter Document',
                                'visible'=>$model->educationAttained==2,
                                'value' => call_user_func(function ($data) use($refund_application_id,$Employer_letter_Document,$action) {
                                    return Html::a("VIEW", ['site/download', 'id'=>$refund_application_id,'attachmentType'=>$Employer_letter_Document,'action'=>$action]);
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
                <?php if($model->refundClaimant->f4type !=1){ ?>
                <?= Html::a('Update/Edit Details', ['updatef4education', 'id' => $model->refund_claimant_id], ['class' => 'btn btn-primary']) ?>
                <?php } ?>
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