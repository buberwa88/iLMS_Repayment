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
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refund_type_id = $resultsCheckResultsGeneral->refund_type_id;
$resultRefundApplicationGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$resultsCheckCount = RefundApplication::getStageCheckedBankDetails($refund_application_id);
$educationAttained = $resultsCheckResultsGeneral->educationAttained;

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

if ($resultsCheckCount > 0 && $refund_type_id == 1) {
    $link = 'site/index-bankdetails';
}
if ($resultsCheckCount == 0 && $refund_type_id == 1) {
    $link = 'site/create-refund-bankdetails';
}
if ($refund_type_id == 1) {
    $title = "Step " . $step4 . ": Employment Details";
}
if ($refund_type_id == 2) {
    $title = "Step 2: Employment Details";
}
if (count($resultRefundApplicationGeneral->liquidation_letter_number) == 0 && $refund_type_id == 2) {
    $link = 'site/create-repaymentdetails';
}
if (count($resultRefundApplicationGeneral->liquidation_letter_number) > 0 && $refund_type_id == 2) {
    $link = 'site/index-repaymentdetails';
}
/*
  if ($resultsCheckCount > 0 && $refund_type_id==2) {
  $link='site/index-bankdetails';
  }
 */
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
            $modelRefundClaimantEducationHistory = RefundClaimantEmployment::find()->where("refund_application_id={$refund_application_id}")->all();


            $sn = 0;
            foreach ($modelRefundClaimantEducationHistory as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => 'Employer Name',
                                'visible' => $model->employer_name != '',
                                //'value'=>$model->employer_name,
                                'value' => call_user_func(function ($data) {
                                            if ($data->employer_name != '') {
                                                return \frontend\modules\repayment\models\Employer::getEmployerCategory($data->employer_name)->employer_name;
                                            } else {
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
                                'label' => 'Employee ID/Check #',
                                'value' => $model->employee_id,
                            //'labelColOptions'=>['style'=>'width:20%'],
                            //'valueColOptions'=>['style'=>'width:30%'],
                            ]
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
    <?= Html::a('Update/Edit', ['update-employment-details', 'id' => $model->refund_claimant_employment_id, 'emploID' => $model->refund_claimant_employment_id], ['class' => 'btn btn-primary']) ?>
        <?php
        echo "</p></div>";
    }
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