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
use frontend\modules\repayment\models\RefundApplication;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */
/* @var $form yii\widgets\ActiveForm */
$list = [1 => 'Yes', 2 => 'No'];
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;

$listFormiv = [1 => 'NECTA STUDENTS [Completed in Tanzania]', 2 => 'NON NECTA STUDENTS [Holders of Foreign Certificates]'];
$yearmax = date("Y");
for ($y = 1982; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
    $cancel="site/refund-liststeps";



?>
<script type="text/javascript">
    function generalShow(element){
        //alert(element);
        var educationLevelVa=$('#educationAttained_id input:checked').val();
        if (educationLevelVa==1) {
            document.getElementById('f4education_show').style.display = 'block';
            document.getElementById('belowF4show').style.display = 'none';
        }else if(educationLevelVa==2){
            document.getElementById('f4education_show').style.display = 'none';
            document.getElementById('belowF4show').style.display = 'block';
        }else {
            document.getElementById('f4education_show').style.display = 'none';
            document.getElementById('belowF4show').style.display = 'none';
        }
    }

    function setRefundf4ed(type) {
        //alert(type);
        var educationCatV=$('#f4type_id input:checked').val();
        if (educationCatV == 1) {
            document.getElementById("general").style.display = "block";
            document.getElementById("necta").style.display = "block";
            document.getElementById("nonnecta").style.display = "none";
            document.getElementById("f4certificateDoc").style.display = "none";
            $("#school_block_id").attr('maxlength','16');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_id').attr('style', 'display:none');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:none');
            $("#refundclaimant-f4indexno").attr('maxlength','10');
        }else if (educationCatV == 2) {
            document.getElementById("general").style.display = "block";
            document.getElementById("necta").style.display = "none";
            document.getElementById("nonnecta").style.display = "block";
            document.getElementById("f4certificateDoc").style.display = "block";
            $("#refundclaimant-f4indexno").attr('maxlength','16');
            $('#nonnecta_block_id').attr('style', 'display:block');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:block');
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
    echo $form->field($model, 'educationAttained')->label('Have you graduated from the Form IV Education?')->radioList($list,
        [
        'inline'=>true,
        'id'=>educationAttained_id,
        'onchange'=>'generalShow(this)',
        ]);
    ?>
    <br/>
    <div id="belowF4show" style="display:none">
        <legend><small><strong>Provide the below Detail(s)</strong></small></legend>
        <?php
        echo $form->field($model, 'employer_letter_document')->label('Employer Letter Document:')->widget(FileInput::classname(), [
            'options' => ['accept' => 'site/pdf'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => TRUE,
                'showUpload' => false,
                // 'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                'browseLabel' =>  'Employer Letter Document (required format .pdf only)',
                'initialPreview'=>[
                    "$model->employer_letter_document",

                ],
                'initialCaption'=>$model->employer_letter_document,
                'initialPreviewAsData'=>true,
            ],
            //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
        ]);
        ?>
    </div>
    <div id="f4education_show" style="display:none">
        <legend><small><strong>SELECT F4 CATEGORY FROM THE BELOW OPTIONS</strong></small></legend>
        <?php
        echo $form->field($model, 'f4type')->label(" ")->radioList($listFormiv,
            [
                'inline'=>true,
                'id'=>f4type_id,
                'onchange'=>'setRefundf4ed(this)',
            ]);
        ?>



        <div style='display:none;' id="general">
            <div class="alert alert-info alert-dismissible" id="labelshow">

                <h4 class="necta" id="necta"><i class="icon fa fa-info"></i>  YOU ARE  APPLYING AS  NECTA  STUDENTS</h4>
                <h4 class="nonnecta" id="nonnecta">
                    <i class="icon fa fa-info"></i>YOU ARE APPLYING AS  NON NECTA STUDENTS</h4>
            </div>
            <?php
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'id' => "school_block_id",
                'columns' => 2,
                'attributes' => [
                    'f4indexno' => ['type' => Form::INPUT_TEXT, 'label' => 'F4 Index #',

                        'options' => ['maxlength'=>10,'placeholder' => '',
                            //'onchange' => 'check_necta()',
                            'data-toggle' => 'tooltip',
                            'data-placement' =>'top','title' => '']],
                    'f4_completion_year' => ['type' => Form::INPUT_WIDGET,
                        'widgetClass' => \kartik\select2\Select2::className(),
                        'label' => 'Completion Year',
                        'options' => [
                            'data' => $year,
                            'options' => [
                                'prompt' => 'Select Completion Year',
                                //'onchange' => 'check_necta()'
                                //'id'=>'entry_year_id'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ],
                    ],
                ]
            ]);
            ?>
            <?php
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 2,
                'id' => "nonnecta_block_id",
                'attributes' => [
                    'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
                    'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
                    'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter .']],
                ]
            ]);
            ?>
            <div style='display:none;' id="f4certificateDoc">
                <?php
                echo $form->field($model, 'f4_certificate_document')->label('F4 Certificate Document:')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'site/pdf'],
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showRemove' => TRUE,
                        'showUpload' => false,
                        // 'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                        'browseLabel' =>  'Certificate Document (required format .pdf only)',
                        'initialPreview'=>[
                            "$model->f4_certificate_document",

                        ],
                        'initialCaption'=>$model->f4_certificate_document,
                        'initialPreviewAsData'=>true,
                    ],

                ])->hint('Attach the Certificate Document Having the Same Information as Provided Above');
                ?>
            </div>
        </div>
    </div>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Submit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", [$cancel], ['class' => 'btn btn-warning']);

        ActiveForm::end();
        ?>
    </div>
    <br/></br/>
    <div class="rowQA" id="showBackNext" style="display:none">
        <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/index-employment-details']);?></div>
        <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
    </div>
</div>
