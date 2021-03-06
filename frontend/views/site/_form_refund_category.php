<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\captcha\Captcha;
use kartik\widgets\FileInput;

$list = [1 => 'NON-BENEFICIARY', 2 => 'OVER DEDUCTED', 3 => 'DECEASED'];

$nonbeneficiaryExplanation='Non-Beneficiary à Non-beneficiary refund type refers to the refund given to a claimant that was deducted but has never been a loan beneficiary of the HESLB';
$overdeductedExplanation='Over-deducted Loan Beneficiary à refers to the refund given to a claimant who has been deducted beyond what the HESLB owe the loan beneficiary. The deductions are usually beyond what they are to repay';
$deceasedExplanation='Deceased à refers to the refund given for a deceased either non-beneficiary or over-dedcuted beneficiary.';
$deceased="Jaza Taarifa za Msimamizi wa Mirathi ya Familia";
?>
<script>
    function setRefundType(type) {
        //alert(type);
        //var refundTypeV=$('#Reftype_id input:checked').val();
        if (type == 1) {
            document.getElementById("general").style.display = "block";
            document.getElementById("nonbeneficiarylabel").style.display = "block";
            document.getElementById("overdeductedlabel").style.display = "none";
            document.getElementById("deceasedlabel").style.display = "none";
            $('#switch_right').val('1');
            $("#school_block_id").attr('maxlength','16');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_id').attr('style', 'display:none');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:none');
            $("#refundclaimant-f4indexno").attr('maxlength','10');
            $(".custom-label").html('Percentage');
        }else if (type == 2) {
            document.getElementById("general").style.display = "block";
            document.getElementById("nonbeneficiarylabel").style.display = "none";
            document.getElementById("overdeductedlabel").style.display = "block";
            document.getElementById("deceasedlabel").style.display = "none";
            $('#switch_right').val('2');
            $("#refundclaimant-f4indexno").attr('maxlength','16');
            $('#nonnecta_block_id').attr('style', 'display:block');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:block');
        }else if (type == 3) {
            document.getElementById("general").style.display = "block";
            document.getElementById("nonbeneficiarylabel").style.display = "none";
            document.getElementById("overdeductedlabel").style.display = "none";
            document.getElementById("deceasedlabel").style.display = "block";
            $('#switch_right').val('3');
            $("#refundclaimant-f4indexno").attr('maxlength','16');
            $('#nonnecta_block_id').attr('style', 'display:block');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:block');
        }
}
</script>

<style>
    iframe{
        border: 0;
    }
</style>

<?php
$incomplete=0;
//$this->title ='Application for Refund, Select the Refund Type:';
//$this->params['breadcrumbs'][] = 'Refund Application';
?>
<div class="education-create">
    <div class="panel panel-info">
        <div class="panel-body">
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                        </div>
                        <div class="panel-body">
                            <p><b>NON-BENEFICIARY </b>(Non-Beneficiary à Non-beneficiary refund type refers to the refund given to a claimant that was deducted but has never been a loan beneficiary of the HESLB) </p>
                            <center>
                                <br/>
                                <br/>
                                <label class="radio-inline"><button type="button"  class="btn btn-block btn-primary btn-lg" name="Education[is_necta]" onclick="setRefundType('1')" value="1">NON-BENEFICIARY</label>
                            </center>
                        </div>
                    </div>
            </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body">
                            <p><b> OVER DEDUCTED </b>(Over-deducted Loan Beneficiary à refers to the refund given to a claimant who has been deducted beyond what the HESLB owe the loan beneficiary. The deductions are usually beyond what they are to repay) </p>
                            <center>
                                <label class="radio-inline"><button type="button" class="btn btn-block btn-warning btn-lg" name="Education[is_necta]" onclick="setRefundType('2')" value="2" >OVER DEDUCTED</label>
                            </center>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body">
                            <p><b> DECEASED </b>(Deceased à refers to the refund given for a deceased either non-beneficiary or over-dedcuted beneficiary.) </p>
                            <center>
                                <br/><br/><br/>
                                <label class="radio-inline"><button type="button" class="btn btn-block btn-success btn-lg" name="Education[is_necta]" onclick="setRefundType('3')" value="3">DECEASED</label>
                            </center>
                        </div>
                    </div>
                </div>

            <div class="col-lg-12">
                <?php
                $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'options' => ['enctype' => 'multipart/form-data'],
                    'enableClientValidation' => TRUE,
                ]);
                ?>
                <div style='display:none;' id="general">
                    <div class="alert alert-info alert-dismissible" id="labelshow">
                        <h4 class="nonbeneficiarylabel" id="nonbeneficiarylabel"><i class="icon fa fa-info"></i>  YOU ARE  REGISTERING AS  NON-BENEFICIARY CLAIMANT</h4>
                        <h4 class="overdeductedlabel" id="overdeductedlabel"><i class="icon fa fa-info"></i>YOU ARE REGISTERING AS  OVER DEDUCTED CLAIMANT</h4>
                        <h4 class="deceasedlabel" id="deceasedlabel"><i class="icon fa fa-info"></i>YOU ARE REGISTERING THE REFUND CLAIM FOR DECEASED<br/><br/>
<?php echo "(<em>".$deceased."</em>)";?>
                        </h4>
                    </div>
  <?= $form->field($model, 'refund_type')->label(false)->hiddenInput(['maxlength' => true,'id'=>"switch_right"]) ?>
                    <?php
                    echo Form::widget([ // fields with labels
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>2,
                        'attributes'=>[
                            'firstname'=>['label'=>'First Name:','options'=>['placeholder'=>'First Name']],
                            'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
                            'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name']],
                            //'phone_number'=>['label'=>'Phone #:', 'options'=>['placeholder'=>'Phone #']],
                            'email'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address']],
                            'phone_number' => ['label'=>'Phone Number:','type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => '0*********','data-toggle' => 'tooltip',
                                'data-placement' => 'top', 'title' => 'Phone Number eg 07XXXXXXXX or 06XXXXXXXX or 0XXXXXXXXX']],
                        ]
                    ]);
                    ?>
					<?php
                    echo $form->field($model, 'claimant_letter_document')->label('Refund application letter document:')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'site/pdf'],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => TRUE,
                            'showUpload' => false,
                            // 'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                            'browseLabel' =>  'Refund application letter document (required format .pdf only)',
                            'initialPreview'=>[
                                "$model->claimant_letter_document",

                            ],
                            'initialCaption'=>$model->claimant_letter_document,
                            'initialPreviewAsData'=>true,
                        ],
                        //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
                    ]);
                    ?>
                    <?= $form->field($model, 'refund_type_confirmed_nonb')->label(false)->hiddenInput(['value'=>2,'readOnly'=>'readOnly']) ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'captchaAction'=>'/site/captcha','id'=>'captcha_block_id',
                        //'imageOptions' => ['style'=>['width'=>'20%','height'=>'20%']]
                    ]) ?>
                    <div class="text-right">
                        <?= Html::submitButton($model->isNewRecord ? 'Register' : 'Register', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                        <?php
                        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
                        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['/application/default/home-page'], ['class' => 'btn btn-warning']);

                        ActiveForm::end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>