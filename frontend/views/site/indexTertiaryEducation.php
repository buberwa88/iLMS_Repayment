<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\RefundClaimantEducationHistory;
use frontend\modules\repayment\models\RefundApplication;
use frontend\modules\repayment\models\RefundClaimantEmployment;

//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
$resultsCheckCountEmploymentDetails = RefundClaimantEmployment::getStageChecked($refund_application_id);
/*
  if($refundTypeId==3){
  $title="Step 2: Deceased's Tertiary Education Details";
  }else{
  $title="Step 2: Tertiary Education Details";
  }
 */
//label sequences
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

if ($refundTypeId == 3) {
    $link = "site/create-familysessiondetails";
} else if ($refundTypeId == 1) {
    $title = "Step " . $step3 . ": Tertiary Education Details";

    if ($resultsCheckCountEmploymentDetails == 0) {
        $link = 'site/create-employment-details';
    } else {
        $link = 'site/index-employment-details';
    }
} else if ($refundTypeId == 2) {
    $title = "Step " . $step3 . ": Tertiary Education Details";
} else {
    $title = "Step " . $step3 . ": Tertiary Education Details";
}
//end label step sequence

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$resultsCheckCountSocialFund = RefundApplication::getStageCheckedSocialFund($refund_application_id);
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;
/*
  $link='site/index-employment-details';


  if(count($resultsCheckResultsGeneral->death_certificate_number)==0 && $refundTypeId==3){
  $link='site/create-deathdetails';
  }
  if(count($resultsCheckResultsGeneral->death_certificate_number)>0 && $refundTypeId==3){
  $link='site/index-deathdetails';
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
            <p>
                <?= Html::a('Add New Tertiary Education Details ', ['create-tertiary'], ['class' => 'btn btn-success']) ?>
            </p><br/><br/>
            <?php
            echo kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
//                            'filterModel' => $model,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'Study Level',
                        'value' => function($model) {
                            return $model->studylevel->applicant_category;
                        }
                    //'labelColOptions'=>['style'=>'width:20%'],
                    //'valueColOptions'=>['style'=>'width:30%'],
                    ],
                    [
                        'attribute' => 'institution_name',
                        'label' => 'Univeristy/College',
                        'value' => function($model) {
                            return $model->institution_name;
                        }
                    ], [
                        'attribute' => 'programme_name',
                        'label' => 'Programme',
                        'value' => function($model) {
                            return $model->programme_name;
                        }
                    ],
                    [
                        'attribute' => 'entry_year',
                        'label' => 'Entry Year',
                        'value' => function($model) {
                            return $model->entry_year;
                        }
                    ], [
                        'attribute' => 'entry_year',
                        'label' => 'Entry Year',
                        'value' => function($model) {
                            return $model->completion_year;
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{delete}',
                    ],
                ]
            ]);
            ?>
            <br/></br/>
            <div class="rowQA">
                <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK", ['site/refund-liststeps']); ?></div>
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>", [$link]); ?></div>
            </div>
        </div>
    </div>
