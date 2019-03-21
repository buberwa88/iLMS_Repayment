<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\captcha\Captcha;
$list = [1 => 'NON-BENEFICIARY(Non-beneficiary)', 2 => 'OVER DEDUCTED(Over deducted)', 3 => 'DECEASED(Deceased)'];

$nonbeneficiaryExplanation='Non-Beneficiary à Non-beneficiary refund type refers to the refund given to a claimant that was deducted but has never been a loan beneficiary of the HESLB';
$overdeductedExplanation='Over-deducted Loan Beneficiary à refers to the refund given to a claimant who has been deducted beyond what the HESLB owe the loan beneficiary. The deductions are usually beyond what they are to repay';
$deceasedExplanation='Deceased à refers to the refund given for a deceased either non-beneficiary or over-dedcuted beneficiary.';
$deceased="Jaza Taarifa za Msimamizi wa Mirathi ya Familia";
?>
<script>
    function setRefundType(type) {
        //alert(type);
        var refundTypeV=$('#Reftype_id input:checked').val();
        if (refundTypeV == 1) {
            document.getElementById("general").style.display = "block";
            document.getElementById("nonbeneficiarylabel").style.display = "block";
            document.getElementById("overdeductedlabel").style.display = "none";
            document.getElementById("deceasedlabel").style.display = "none";
            $("#school_block_id").attr('maxlength','16');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_id').attr('style', 'display:none');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:none');
            $("#refundclaimant-f4indexno").attr('maxlength','10');
            $(".custom-label").html('Percentage');
        }else if (refundTypeV == 2) {
            document.getElementById("general").style.display = "block";
            document.getElementById("nonbeneficiarylabel").style.display = "none";
            document.getElementById("overdeductedlabel").style.display = "block";
            document.getElementById("deceasedlabel").style.display = "none";
            $("#refundclaimant-f4indexno").attr('maxlength','16');
            $('#nonnecta_block_id').attr('style', 'display:block');
            $('#school_block_id').attr('style', 'display:block');
            $('#nonnecta_block_completionyear_id').attr('style', 'display:block');
        }else if (refundTypeV == 3) {
            document.getElementById("general").style.display = "block";
            document.getElementById("nonbeneficiarylabel").style.display = "none";
            document.getElementById("overdeductedlabel").style.display = "none";
            document.getElementById("deceasedlabel").style.display = "block";
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
            <div class="col-lg-12">
                <?php
                $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'options' => ['enctype' => 'multipart/form-data'],
                    'enableClientValidation' => TRUE,
                ]);
                ?>
                <?php
                echo $form->field($model, 'refund_type')->label(false)->radioList($list,
                    [
                        'inline'=>true,
                        'id'=>Reftype_id,
                        'onchange'=>'setRefundType(this)',
                    ]);
                ?>

                <div style='display:none;' id="general">
                    <div class="alert alert-info alert-dismissible" id="labelshow">
                        <h4 class="nonbeneficiarylabel" id="nonbeneficiarylabel"><i class="icon fa fa-info"></i>  YOU ARE  REGISTERING AS  NON-BENEFICIARY CLAIMANT<br/>
                            <?php echo "(<em>".$nonbeneficiaryExplanation."</em>)";?></h4>
                        <h4 class="overdeductedlabel" id="overdeductedlabel"><i class="icon fa fa-info"></i>YOU ARE REGISTERING AS  OVER DEDUCTED CLAIMANT<br/>
                            <?php echo "(<em>".$overdeductedExplanation."</em>)";?></h4>
                        <h4 class="deceasedlabel" id="deceasedlabel"><i class="icon fa fa-info"></i>YOU ARE REGISTERING AS  DECEASED CLAIMANT<br/><br/>
<?php echo "(<em>".$deceased."</em>)";?>
                        </h4>
                    </div>
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
                        ]
                    ]);
                    ?>
                    <?=
                    $form->field($model, 'phone_number')->label('Phone Number:')->widget(\yii\widgets\MaskedInput::className(), [
                        'mask' => '255 999 999 999',
                        //'options' => ['data-toggle' => 'tooltip',
                        //'data-placement' => 'top', 'title' => 'Phone Number eg 07XXXXXXXX or 06XXXXXXXX or 0XXXXXXXXX']
                    ])->hint('Phone Number eg 255 7XXXXXXXX or 255 6XXXXXXXX or 255 XXXXXXXXX');
                    ?>
                    <?= $form->field($model, 'refund_type_confirmed_nonb')->label(false)->hiddenInput(['value'=>2,'readOnly'=>'readOnly']) ?>


                    <?php
                    echo $form->field($model, 'court_letter_certificate_document')->label('Appointed estate admin confirmation document:')->widget(FileInput::classname(), [
                        'options' => ['accept' => 'site/pdf'],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => TRUE,
                            'showUpload' => false,
                            // 'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                            'browseLabel' =>  'Appointed estate admin confirmation document (required format .pdf only)',
                            'initialPreview'=>[
                                "$model->court_letter_certificate_document",

                            ],
                            'initialCaption'=>$model->court_letter_certificate_document,
                            'initialPreviewAsData'=>true,
                        ],
                        //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
                    ]);
                    ?>


                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'captchaAction'=>'/site/captcha','id'=>'captcha_block_id'
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