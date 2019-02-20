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
$resultRefundApplicationGeneral=RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$resultsCheckCount = RefundApplication::getStageCheckedBankDetails($refund_application_id);
if ($resultsCheckCount > 0 && $refund_type_id==1) {
    $link='site/index-bankdetails';
}
if($resultsCheckCount == 0 && $refund_type_id==1) {
    $link='site/create-refund-bankdetails';
}
if($refund_type_id==1){
    $heade="Step 3: Employment Details";
}
if($refund_type_id==2){
    $heade="Step 1: Employment Details";
}
if(count($resultRefundApplicationGeneral->liquidation_letter_number)==0 && $refund_type_id==2){
    $link='site/create-repaymentdetails';
}
if(count($resultRefundApplicationGeneral->liquidation_letter_number) >0 && $refund_type_id==2){
    $link='site/index-repaymentdetails';
}
/*
if ($resultsCheckCount > 0 && $refund_type_id==2) {
    $link='site/index-bankdetails';
}
*/
$this->title = $heade;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Add New Employment Details ', ['create-employment-details'], ['class' => 'btn btn-success']) ?>
            </p><br/><br/>
            <?php  $modelRefundClaimantEducationHistory = RefundClaimantEmployment::find()->where("refund_application_id={$refund_application_id}")->all();


            $sn = 0;
            foreach ($modelRefundClaimantEducationHistory as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => 'Employer Name',
                                //'value'=>$model->employer_name,
                                'value'=>call_user_func(function ($data) {
                                    if($data->employer_name !=''){
    return \frontend\modules\repayment\models\Employer::getEmployerCategory($data->employer_name)->employer_name;
                                    }else{
                                        return '';
                                    }
                                }, $model),
                                'format' => 'raw',
                            ],

                        ],
                    ],

                    [
                        'columns' => [

                            [
                                'label'=>'Employee ID/Check #',
                                'value'=>$model->employee_id,
                                //'labelColOptions'=>['style'=>'width:20%'],
                                //'valueColOptions'=>['style'=>'width:30%'],
                            ]
                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>'Start Date',
                                'value'=>$model->start_date,
                                //'labelColOptions'=>['style'=>'width:20%'],
                                //'valueColOptions'=>['style'=>'width:30%'],
                            ]
                        ],
                    ],

                    [
                        'columns' => [

                            [
                                'label'=>'End Date',
                                'value'=>$model->end_date,
                                //'labelColOptions'=>['style'=>'width:20%'],
                                //'valueColOptions'=>['style'=>'width:30%'],
                            ],
                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>'First Salary/Pay Slip Document',
                                'value'=>call_user_func(function ($data) {
                                    if($data->first_slip_document !=''){
                                        return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->first_slip_document . '")','class'=>'label label-primary']);
                                    }else{
                                        return $data->first_slip_document;
                                    }
                                }, $model),
                                'format' => 'raw',

                            ],
                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label'=>'Second Salary/Pay Slip Document',
                'value'=>call_user_func(function ($data) {
                    if($data->second_slip_document !=''){
                        return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->second_slip_document . '")','class'=>'label label-primary']);
                    }else{
                        return $data->second_slip_document;
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
                <?= Html::a('Update/Edit', ['update-contactperson', 'id' => $model->refund_claimant_employment_id,'emploID'=>$model->refund_claimant_employment_id], ['class' => 'btn btn-primary']) ?>
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