<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\RefundClaimantEducationHistory;
use frontend\modules\repayment\models\RefundApplication;
//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
if($refundTypeId==3){
    $title="Step 2: Deceased's Tertiary Education Details";
}else{
    $title="Step 2: Tertiary Education Details";
}
//end set session

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$resultsCheckCountSocialFund = RefundApplication::getStageCheckedSocialFund($refund_application_id);
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;

$link='site/index-employment-details';


if(count($resultsCheckResultsGeneral->death_certificate_number)==0 && $refundTypeId==3){
    $link='site/create-deathdetails';
}
if(count($resultsCheckResultsGeneral->death_certificate_number)>0 && $refundTypeId==3){
    $link='site/index-deathdetails';
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
   <p>
        <?= Html::a('Add New Tertiary Education Details ', ['create-tertiary'], ['class' => 'btn btn-success']) ?>
    </p><br/><br/>
                <?php  $modelRefundClaimantEducationHistory = RefundClaimantEducationHistory::find()->where("refund_application_id={$refund_application_id}")->all();


                $sn = 0;
                foreach ($modelRefundClaimantEducationHistory as $model) {
                    ++$sn;
                    $attributes = [

                        [
                            'columns' => [

                                [
                                    'label' => 'Study Level',
                                    'value'=>$model->studylevel->applicant_category,
                                    //'labelColOptions'=>['style'=>'width:20%'],
                                    //'valueColOptions'=>['style'=>'width:30%'],
                                ],

                            ],
                        ],

                        [
                            'columns' => [

                                [
                                    'label'=>'Institution',
                                    'value'=>$model->institution->institution_name,
                                    //'labelColOptions'=>['style'=>'width:20%'],
                                    //'valueColOptions'=>['style'=>'width:30%'],
                                ]
                            ],
                        ],
                        [
                            'columns' => [

                                [
                                    'label'=>'Programme',
                                    'value'=>$model->program->programme_name,
                                    //'labelColOptions'=>['style'=>'width:20%'],
                                    //'valueColOptions'=>['style'=>'width:30%'],
                                ]
                            ],
                        ],

                        [
                            'columns' => [

                                [
                                    'label'=>'Entry Year',
                                    'value'=>$model->entry_year,
                                    //'labelColOptions'=>['style'=>'width:20%'],
                                    //'valueColOptions'=>['style'=>'width:30%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [

                                [
                                    'label'=>'Completion Year',
                                    'value'=>$model->completion_year,
                                    //'labelColOptions'=>['style'=>'width:20%'],
                                    //'valueColOptions'=>['style'=>'width:30%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [

                                [
                                    'label'=>'Certificate Document',
                                    'value'=>call_user_func(function ($data) {
                                        if($data->certificate_document !=''){
                                            return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->certificate_document. '")','class'=>'label label-primary']);
                                        }else{
                                            return $data->certificate_document;
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
                    echo '<div class="text-right">	<p>';
                    ?>
                    <?= Html::a('Update/Edit', ['update-contactperson', 'id' => $model->refund_education_history_id,'emploID'=>$model->refund_education_history_id], ['class' => 'btn btn-primary']) ?>
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
