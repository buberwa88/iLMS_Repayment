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
//set session
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
//end set session

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\repayment\models\RefundClaimantEducationHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Step 1: Form 4 Education';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-education-history-create">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
            <?php  $modelRefundClaimant = RefundClaimant::find()->where("refund_claimant_id={$refundClaimantid}")->all();


            $sn = 0;
            foreach ($modelRefundClaimant as $model) {
                ++$sn;
                $attributes = [

                    [
                        'columns' => [

                            [
                                'label' => 'F4 Index #',
                                'value'=>$model->f4indexno,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Completion Year',
                                'value'=>$model->f4_completion_year,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'First Name',
                                'value'=>$model->necta_firstname,
                            ],

                        ],
                    ],
                    [
                        'columns' => [

                            [
                                'label' => 'Middle Name',
                                'value'=>$model->necta_middlename,
                            ],

                        ],
                    ],
                [
                    'columns' => [

                        [
                            'label' => 'Last Name',
                            'value'=>$model->necta_surname,
                        ],

                    ],
                ],

                    [
                        'columns' => [

                            [
                                'label'=>'F4 Certificate Document',
                'value'=>call_user_func(function ($data) {
                    if($data->f4_certificate_document !=''){
                        return  yii\helpers\Html::a("VIEW", '#', ['onclick' => 'viewUploadedFile("uploads/applicant_attachments/' . $data->f4_certificate_document . '")','class'=>'label label-primary']);
                    }else{
                        return $data->f4_certificate_document;
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
                <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/index-tertiary-education']);?></div>
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