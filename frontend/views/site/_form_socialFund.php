<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;
use kartik\date\DatePicker;
use kartik\widgets\FileInput;
use frontend\modules\repayment\models\EmployerSearch;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */
/* @var $form yii\widgets\ActiveForm */
$list = [1 => 'Yes', 2 => 'No'];
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
?>
<script type="text/javascript">
    // window.onload = function() {
    //     document.getElementById('employed_show').style.display = 'block';
    //         if(ShowemployementDetails(element)) {
    //             document.getElementById('showBackNext').style.display = 'none';
    //         }else{
    //             document.getElementById('showBackNext').style.display = 'block';
    //         }
    //
    // };

    function ShowFundStatus(element){
        //alert(element);
        var social_fund_statusV=$('#social_fund_status_id input:checked').val();
        if (social_fund_statusV==1) {
            document.getElementById('soccialFundDocument_show').style.display = 'block';
        } else if(social_fund_statusV==2){
            $('#social_fund_document_id').val('');
            $('#social_fund_receipt_document_id').val('');
            document.getElementById('soccialFundDocument_show').style.display = 'none';
        }else {
            document.getElementById('soccialFundDocument_show').style.display = 'none';
        }
    }
	function ShowFundStatusDocument(element){
        //alert(element);
        var social_fund_statusV=$('#soccialFundDocument_id input:checked').val();
        if (social_fund_statusV==1) {
            document.getElementById('employed_show').style.display = 'block';
        } else if(social_fund_statusV==2){
            $('#social_fund_document_id').val('');
            $('#social_fund_receipt_document_id').val('');
            document.getElementById('employed_show').style.display = 'none';
        }else {
            document.getElementById('employed_show').style.display = 'none';
        }
    }
</script>
<style>
    .rowQA {
        width: 100%;
        /*margin: 0 auto;*/
        text-align: center;
    }
    .block {
        width: 100px;
        /*float: left;*/
        display: inline-block;
        zoom: 1;
    }
</style>
<div class="refund-education-history-form">
    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data'],
        'enableClientValidation' => TRUE,]);
    ?>
    <?php
    echo $form->field($model, 'social_fund_status')->label('Are You Retired?')->radioList($list,
        [
        'inline'=>true,
        'id'=>social_fund_status_id,
        'onchange'=>'ShowFundStatus(this)',
        ]);
    ?>
	<div id="soccialFundDocument_show" style="display:none">
	<?php
    echo $form->field($model, 'soccialFundDocument')->label('Do You Have Social Security Fund and Receipt Document?')->radioList($list,
        [
        'inline'=>true,
        'id'=>soccialFundDocument_id,
        'onchange'=>'ShowFundStatusDocument(this)',
        ]);
    ?>
	</div>
    <br/>
    <div id="employed_show" style="display:none">
        <legend><small><strong>Provide the below Detail(s)</strong></small></legend>
        <?php
        echo $form->field($model, 'social_fund_document')->label('Social Security Fund Document:')->widget(FileInput::classname(), [
            'options' => ['accept' => 'site/pdf'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => TRUE,
                'showUpload' => false,
                // 'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                'browseLabel' =>  'Social Security Fund Document (required format .pdf only)',
                'initialPreview'=>[
                    "$model->social_fund_document",

                ],
                'initialCaption'=>$model->social_fund_document,
                'initialPreviewAsData'=>true,
            ],
            //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
        ]);
        ?>
        <?php
        echo $form->field($model, 'social_fund_receipt_document')->label('Receipt Document:')->widget(FileInput::classname(), [
            'options' => ['accept' => 'site/pdf'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => TRUE,
                'showUpload' => false,
                // 'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                'browseLabel' =>  'Receipt Document (required format .pdf only)',
                'initialPreview'=>[
                    "$model->social_fund_receipt_document",

                ],
                'initialCaption'=>$model->social_fund_receipt_document,
                'initialPreviewAsData'=>true,
            ],
            //'hint'=>'<i>Provide the second latest Salary/Pay Slip Document</i>',
        ])->hint('Provide receipt document from Social Security Fund');
        ?>

    </div>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['site/list-steps-nonbeneficiary','id'=>$refundClaimantid], ['class' => 'btn btn-warning']);

        ActiveForm::end();
        ?>
    </div>
    <br/></br/>
    <div class="rowQA" id="showBackNext" style="display:none">
        <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/index-employment-details']);?></div>
        <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
    </div>
</div>
