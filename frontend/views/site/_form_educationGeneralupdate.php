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
$model->employer_letter_document=$resultsCheckResultsGeneral->employer_letter_document;

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
        var displaymyDiv = document.getElementById("myDIV");
        var displayDivbelowF4show = document.getElementById("belowF4show");
        var displayDivolevel_options=document.getElementById("olevel_options");
        //var f4type=$('#f4type_id input:checked').val();
        if (educationLevelVa==1) {
            //document.getElementById('f4education_show').style.display = 'block';
            $('.field-refundClaimant-f4type').attr('style', 'display:block');
            document.getElementById('belowF4show').style.display = 'none';
            displayDivolevel_options.style.display = "block";
            displayDivbelowF4show.style.display = "none";
            $('#employer_letter_document_id').val('');
        }else if(educationLevelVa==2){
            //document.getElementById('f4education_show').style.display = 'none';
            $('.field-refundClaimant-f4type').attr('style', 'display:none');
            document.getElementById('belowF4show').style.display = 'block';
            displayDivbelowF4show.style.display = "block";
            displayDivolevel_options.style.display = "none";
            displaymyDiv.style.display = "none";
            $('#f4_certificate_document_id').val('');
        }else {
            //document.getElementById('f4education_show').style.display = 'none';
            document.getElementById('belowF4show').style.display = 'none';
            displayDivbelowF4show.style.display = "none";
            displayDivolevel_options.style.display = "none";
            displaymyDiv.style.display = "none";
            $('.field-refundClaimant-f4type').attr('style', 'display:none');
            $('#f4_certificate_document_id').val('');
            $('#employer_letter_document_id').val('');
        }
    }

    function setRefundf4ed(type) {
        //alert(type);
        var educationCatV=$('#f4type_id input:checked').val();
        var displaynecta = document.getElementById("necta");
        var displaynonnecta = document.getElementById("nonnecta");
        var displaynonnectablock = document.getElementById("nonnectablock");
        var displaymyDiv = document.getElementById("myDIV");
        var displaymyDivNecta = document.getElementById("myDivNecta");
        if (educationCatV == 1) {
            $('.field-refundClaimant-f4indexno').attr('style', 'display:block');
            $('.field-refundClaimant-f4_completion_year').attr('style', 'display:block');
            $('.field-refundClaimant-firstname').attr('style', 'display:none');
            $('.field-refundClaimant-middlename').attr('style', 'display:none');
            $('.field-refundClaimant-surname').attr('style', 'display:none');
            $('.field-refundClaimant-f4_certificate_document').attr('style', 'display:none');
            $('#switch_right').val('1');
            $("#school_block_id").attr('maxlength','16');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_id').attr('style', 'display:none');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:none');
            $("#refundclaimant-f4indexno").attr('maxlength','10');
            $('#create-button-id').attr('style', 'display: none');
            $('#reset-button-id').attr('style', 'display: none');
            displaynecta.style.display = "block";
            displaymyDiv.style.display = "block";
            displaynonnecta.style.display = "none";
            displaynonnectablock.style.display = "none";
        }else if (educationCatV == 2) {
            $('.field-refundClaimant-f4indexno').attr('style', 'display:block');
            $('.field-refundClaimant-f4_completion_year').attr('style', 'display:block');
            $('.field-refundClaimant-firstname').attr('style', 'display:block');
            $('.field-refundClaimant-middlename').attr('style', 'display:block');
            $('.field-refundClaimant-surname').attr('style', 'display:block');
            $('.field-refundClaimant-f4_certificate_document').attr('style', 'display:block');
            $("#refundclaimant-f4indexno").attr('maxlength','16');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_id').attr('style', 'display:block');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:block');
            $('#switch_right').val('2');
            $('#create-button-id').attr('style', 'display: block');
            $('#reset-button-id').attr('style', 'display: block');
            displaynonnecta.style.display = "block";
            displaynonnectablock.style.display = "block";
            displaymyDiv.style.display = "block";
            displaynecta.style.display = "none";
            displaymyDivNecta.style.display = "none";
            $('#school_block_id').val('');
        }else{
            $('.field-refundClaimant-f4indexno').attr('style', 'display:none');
            $('.field-refundClaimant-f4_completion_year').attr('style', 'display:none');
            $('.field-refundClaimant-firstname').attr('style', 'display:none');
            $('.field-refundClaimant-middlename').attr('style', 'display:none');
            $('.field-refundClaimant-surname').attr('style', 'display:none');
            $('.field-refundClaimant-f4_certificate_document').attr('style', 'display:none');
            displaynonnecta.style.display = "none";
            displaynecta.style.display = "none";
            displaynonnectablock.style.display = "none";
            displaymyDiv.style.display = "none";
        }
    }

    function check_refundnecta() {
        var registrationId = document.getElementById('refundclaimant-f4indexno').value;
        var year = document.getElementById('refundclaimant-f4_completion_year').value;
        var status = document.getElementById('switch_right').value;
        //alert(status);
        if(status == 1){
           $('#create-button-id').attr('style', 'display: none');
        }
        //document.getElementById("w5").style.display = "none";

        if (registrationId != "" && year != "" && status == 1) {
            document.getElementById("loader").style.display = "block";
            document.getElementById("myDivNecta").style.display = "none";

            $.ajax({
                type: 'post',
                //dataType: 'json',
                url: "<?= Yii::$app->getUrlManager()->createUrl('/repayment/refund-claimant/nectadetails'); ?>",
                data: {registrationId: registrationId, year: year},
                success: function (data) {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("myDivNecta").style.display = "block";
                    $('#myDivNecta').html(data);
                }
            });
        }

        return false;
    }
    function check_status() {
        if ($('#refundnectadata-validated').is(':checked')) {
            $('#create-button-id').attr('style', 'display: block');
        } else {
            $('#create-button-id').attr('style', 'display: none');
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
    #myDivNecta{
        margin-left:50px;
    }
    #create-button-id{
        text-align:right;
    }
</style>
<?php
if ($model->f4type==1 && $model->educationAttained==1) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        .field-refundClaimant-f4type .field-refundClaimant-f4indexno .field-refundClaimant-f4_completion_year{
            display:none;
        }
        #necta{
        display:block;
        }
        #nonnecta{
        display:none;
        }
        #nonnectablock{
        display:none;
        }
        #belowF4show{
        display:none;
        }
    </style>';
} else if($model->f4type==2  && $model->educationAttained==1){
    echo '<style>
      .field-refundClaimant-f4type .field-refundClaimant-f4indexno .field-refundClaimant-f4_completion_year .field-refundClaimant-firstname .field-refundClaimant-middlename .field-refundClaimant-surname .field-refundClaimant-f4_certificate_document{
            display: block;
        }
        #necta{
        display:none;
        }
        #nonnecta{
        display:block;
        }
        #nonnectablock{
        display:block;
        }
        #belowF4show{
        display:none;
        }
    </style>';
}else{
    echo '<style>
      .field-refundClaimant-f4type .field-refundClaimant-f4indexno .field-refundClaimant-f4_completion_year .field-refundClaimant-firstname .field-refundClaimant-middlename .field-refundClaimant-surname .field-refundClaimant-f4_certificate_document {
            display:none;
        }
        #necta{
        display:none;
        }
        #nonnecta{
        display:none;
        }
        #nonnectablock{
        display:none;
        }
        #belowF4show{
        display:none;
        }
    </style>';
}

if ($model->educationAttained==2) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        #myDIV{
        display:none;
        }
        #olevel_options{
        display:none;
        }
        #belowF4show{
        display:block;
        }
    </style>';
}
?>
<div class="refund-education-history-form">
    <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data'],
        'enableClientValidation' => TRUE,]);
    ?>
    <?php
    echo $form->field($model, 'educationAttained')->label('Have you graduated from Olevel Education?')->radioList($list,
        [
        'inline'=>true,
        'id'=>educationAttained_id,
        'onchange'=>'generalShow(this)',
        ]);
    ?>
    <br/>
    <div id="belowF4show">
        <legend><small><strong>Provide the below Detail(s)</strong></small></legend>
        <?php
        echo $form->field($model, 'employer_letter_document')->label('Employer Letter Document:')->widget(FileInput::classname(), [
            'options' => ['accept' => 'site/pdf','id' => 'employer_letter_document_id'],
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
                'initialPreviewConfig' => [
                    ['type'=> explode(".",$model->employer_letter_document)[1]=="pdf"?"pdf":"image"],
                ],
            ],
            //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
        ]);
        ?>
    </div>
        <div id="olevel_options">
            <legend><small><strong>OLEVEL EDUCATION OPTIONS</strong></small></legend>
        <?php
        echo $form->field($model, 'f4type')->label(" ")->radioList($listFormiv,
            [
                'inline'=>true,
                'id'=>f4type_id,
                'onchange'=>'setRefundf4ed(this)',
            ]);
        ?>
        </div>

    <div id="myDIV">

            <div class="alert alert-info alert-dismissible">

                <h5 class="necta" id="necta"><i class="icon fa fa-info"></i>  YOU ARE  APPLYING AS  NECTA  STUDENTS</h5>
                <h5 class="nonnecta" id="nonnecta">
                    <i class="icon fa fa-info"></i>YOU ARE APPLYING AS  NON NECTA STUDENTS</h5>
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
                            'onchange' => 'check_refundnecta()',
                            'data-toggle' => 'tooltip',
                            'data-placement' =>'top','title' => '']],
                    'f4_completion_year' => ['type' => Form::INPUT_WIDGET,
                        'widgetClass' => \kartik\select2\Select2::className(),
                        'label' => 'Completion Year',
                        'options' => [
                            'data' => $year,
                            'options' => [
                                'prompt' => 'Select Completion Year',
                                'onchange' => 'check_refundnecta()',
                                //'id'=>'f4_completion_year_id',
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
        echo "<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center><div style='display:none;' id='myDivNecta' class='animate-bottom'></div>";
        ?>
        <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['maxlength' => true,'id'=>"switch_right"]) ?>
        <div id="nonnectablock">
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
<?php
echo $form->field($model, 'f4_certificate_document')->label('F4 Certificate Document:')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'site/pdf','id' => 'f4_certificate_document_id'],
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
                        'initialPreviewConfig' => [
                            ['type'=> explode(".",$model->f4_certificate_document)[1]=="pdf"?"pdf":"image"],
                        ],
                    ],

                ])->hint('Attach the Certificate Document Having the Same Information as Provided Above');
                ?>
    </div>
    </div>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Update' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'create-button-id']) ?>

        <?php
        ActiveForm::end();
        ?>
    </div>
    <br/></br/>
    <div class="rowQA">
        <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/refund-liststeps']);?></div>
        <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/index-tertiary-education']);?></div>
    </div>
</div>
