<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\tabs\TabsX;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\report\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Loan Beneficiary Information';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appleal-default-index">
    <div class="panel panel-info">
        <div class="panel-heading">  
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body" style="margin: 0;">
            <!--Beneficiary Names-->
            <div class="col-xs-7" style="margin-left: 0; padding: 0;">
                <!--<div class="box box-primary">-->
                <div class="col-xs-12">
                    <?php if (Yii::$app->session->hasFlash('failure')) { ?>
                        <div class="alert alert alert-warning" role="alert" style="padding: 3px;">
                            <?php echo Yii::$app->session->getFlash('failure'); ?>
                        </div>
                    <?php } ?>
                    <?php
                    echo $this->render('_beneficiary_particulars', ['model' => $model]);
                    ?>
                </div>
            </div>

            <div class="col-xs-5" style="margin: 0;padding: 0;">
                <div class=" col-xs-12" style="margin: 0;padding: 0;">
                    <div class="col-xs-4" style="border: 1px solid #f4f4f4;height: 170px;margin: 0;margin-right: 4%;padding: 0">
                        <?php
                        $attachment_definition_id = '3';
                        $resultsPath = \backend\modules\application\models\VerificationFrameworkItem::getApplicantAttachmentPath($attachment_definition_id, $model->application_id);
                        ?>
                        <img class="img col-xs-2" src="<?= Yii::$app->params['applicantPhotos'] . $resultsPath->attachment_path ?>" alt=" No Picture">
                    </div>
                    <div class=" box-primary col-xs-7" style="border: 1px solid #f4f4f4;margin: 0%;">
                        <div class="box-header header size-large">
                            <b>Export/Print Options</b>
                        </div> 
                        <?php
                        echo $this->render('_form_beneficiary_print', ['model' => $model]);
                        ?>
                    </div>
                </div>
                <div class="box box-primary col-xs-12" style="margin: 0%;height:auto;min-height:95px;width:97%;">
                    <?php
                    echo $this->render('_operation_menus', ['model' => $model]);
                    ?>
                </div>
            </div>
            <div class="col-xs-12">
                <?php
                echo TabsX::widget([
                    'items' => [
                        [
                            'label' => 'Loan Details',
                            'content' => $this->render('viewRepaymentDetails', ['model' => $model, 'beneficiaryApplications' => $dataProviderBeneficiaryApplications]),
                            'id' => 'atab3',
                            'active' => ($active == 'atab3') ? true : false,
                        ],
                        [
                            'label' => 'Loan Repayments',
                            'content' => $this->render('_beneficiary_repayments', ['model' => $model]),
                            'id' => 'atab3',
                            'active' => ($active == 'atab3') ? true : false,
                        ], [
                            'label' => 'Disbursements',
                            'content' => $this->render('disbursed_loan', ['model' => $model, 'dataProviderDisbursement' => $dataProviderDisbursement, 'searchModelDisbursement' => $searchModelDisbursement]),
                            'id' => 'atab3',
                            'active' => ($active == 'atab3') ? true : false,
                        ],
                        [
                            'label' => 'Loan Allocations',
                            'content' => $this->render('allocation_details', ['model' => $model, 'dataProviderAllocatedLoan' => $dataProviderAllocatedLoan, 'searchModelAllocatedLoan' => $searchModelAllocatedLoan]),
                            'id' => 'atab3',
                            'active' => ($active == 'atab3') ? true : false,
                        ],
                        [
                            'label' => 'Loan Applications',
                            'content' => $this->render('application_details', ['model' => $model, 'dataProviderApplicantAssociate' => $dataProviderApplicantAssociate, 'searchModelApplicantAssociate' => $searchModelApplicantAssociate, 'dataProviderApplicantAttachment' => $dataProviderApplicantAttachment, 'searchModelApplicantAttachment' => $searchModelApplicantAttachment, 'dataProviderEducation' => $dataProviderEducation, 'searchModeleducation' => $searchModeleducation, 'application_id' => $application_id]),
                            'active' => ($active == 'atab1') ? true : false,
                        ],
                        [
                            'label' => 'Appeal',
                            'content' => '',
                            'id' => 'atab3',
                            'active' => ($active == 'atab3') ? true : false,
                        ],
                        [
                            'label' => 'Complain',
                            'content' => '',
                            'id' => 'atab3',
                            'active' => ($active == 'atab3') ? true : false,
                        ],
                    ],
                    'position' => TabsX::POS_ABOVE,
                    'bordered' => true,
                    'encodeLabels' => false
                ]);
                ?>
            </div>
        </div>
    </div>
</div>
