<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\tabs\TabsX;
use kartik\detail\DetailView;
use frontend\modules\repayment\models\RefundClaimantEmployment;
//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
use yii\data\SqlDataProvider;
//end set session

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Step 3: Employment Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    function viewUploadedFile(url) {
        $('#view-attachment-dialog-id').dialog('open');
        $('#view-attachment-iframe-id').attr('src', url);
    }

    function uploadAttachment(url) {
        $('#create-attachment-dialog-id').dialog('open');
        $('#create-attachment-iframe-id').attr('src', url);
    }

    function reloadPage(url){
        document.location.href = url;
    }
</script>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <p>
                <?= Html::a('Add New Employment Details ', ['create-employment-details'], ['class' => 'btn btn-success']) ?>
            </p><br/><br/>
            <?php

            $modelRefundClaimantEmployment1 = RefundClaimantEmployment::find()->where("refund_application_id={$refund_application_id}");

            $modelRefundClaimantEmployment = "select * from refund_claimant_employment where refund_claimant_employment.refund_application_id = {$refund_application_id} ";
            $dataProvider = new SqlDataProvider([
                'sql' => $modelRefundClaimantEmployment,
            ]);

            $sn = 0;



            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'label' => 'Attachment',
                        'value' => function($row) {
                            return $row['employer_name'];
                        }
                    ],
                    [
                        'label' => 'Uploaded',
                        'value' => function($row) {
                            if ($row['first_slip_document'] == NULL || $row['first_slip_document'] == '') {
                                return yii\helpers\Html::label("NO", NULL, ['class' => 'label label-danger']);
                            } else {
                                return yii\helpers\Html::label("YES", NULL, ['class' => 'label label-success']) . "&nbsp;&nbsp;" . yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $row['first_slip_document'] . '")','class'=>'label label-primary']);
                            }
                        },
                        'format' => 'raw',
                    ],
                ]
            ]);

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


            yii\jui\Dialog::begin([
                'id' => 'create-attachment-dialog-id',
                'clientOptions' => [
                    'width' => '500',
                    'height' => '400',
                    'modal' => true,
                    'autoOpen' => false,
                ]
            ]);

            echo '<iframe src="" id="create-attachment-iframe-id" width="100%" height="100%" style="border: 0">';
            echo '</iframe>';
            echo '<br><br>';
            yii\jui\Dialog::end();



            ?>
            <br/></br/>
            <div class="rowQA">
                <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
            </div>
        </div>
    </div>
