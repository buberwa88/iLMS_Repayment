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

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */
/* @var $form yii\widgets\ActiveForm */
$list = [1 => 'Government', 2 => 'Private'];
$list2 = [1 => 'Check Number', 2 => 'Employee ID'];
$cancel="site/refund-liststeps";
?>
<script type="text/javascript">
    function ShowemployementDetails(element){
        //alert(element);
        var employmentStatusV=$('#employed_gvt_private_status_id input:checked').val();
        if (employmentStatusV==1) {
            document.getElementById('employed_show').style.display = 'none';
            document.getElementById('employed_gvt_type').style.display = 'block';
            document.getElementById('employmentStatusV').style.display = 'block';
            document.getElementById('employment_detail_block_id').style.display = 'block';
            //document.getElementById('payment_slip_doc_block_id').style.display = 'block';
            $('#employer_name_id').attr('style', 'display:block');
            $('#employeeID_id').attr('style', 'display:block');
            $('#start_date_id').attr('style', 'display:block');
            $('#end_date_id').attr('style', 'display:block');
        } else if(employmentStatusV==2){
            document.getElementById('employed_show').style.display = 'block';
            document.getElementById('employed_gvt_type').style.display = 'none';
            document.getElementById('employmentStatusV').style.display = 'block';
            document.getElementById('employment_detail_block_id').style.display = 'block';
            document.getElementById('show_employername').style.display = 'block';

            $('#employer_name_id').val('');
            $('#start_date_id').val('');
            $('#end_date_id').val('');
            $('#employed_gvt_check_number_status_id').val('');
            $('#employer_name_id').attr('style', 'display:none');
            $('#start_date_id').attr('style', 'display:none');
            $('#end_date_id').attr('style', 'display:none');
        }else {
            // reset values
            $('#employer_name_id').val('');
            $('#employeeID_id').val('');
            $('#start_date_id').val('');
            $('#end_date_id').val('');

            document.getElementById('employed_show').style.display = 'none';
            document.getElementById('employed_gvt_type').style.display = 'none';
            document.getElementById('employmentStatusV').style.display = 'none';
            document.getElementById('show_employername').style.display = 'none';
        }
    }

    function setGvtCheckNumberEmployee(element){
        //alert(element);
        var employedGVTchckn=$('#employed_gvt_check_number_status_id input:checked').val();
        if (employedGVTchckn==1) {
            document.getElementById('employed_gvt_type').style.display = 'block';
            document.getElementById('employed_show').style.display = 'block';
            document.getElementById('show_employername').style.display = 'none';
        } else if(employedGVTchckn==2){
            $('#social_fund_document_id').val('');
            $('#social_fund_receipt_document_id').val('');
            document.getElementById('employed_gvt_type').style.display = 'block';
            document.getElementById('employed_show').style.display = 'block';
            document.getElementById('show_employername').style.display = 'block';
        }else {
            document.getElementById('employed_gvt_type').style.display = 'none';
            document.getElementById('employed_show').style.display = 'none';
            document.getElementById('show_employername').style.display = 'none';
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
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
    ?>
    <?php
    echo $form->field($model, 'employed_gvt_private_status')->label('Have you been employed government or private?')->radioList($list,
        [
        'inline'=>true,
        'id'=>employed_gvt_private_status_id,
        'onchange'=>'ShowemployementDetails(this)',
        ]);
    ?>
    <br/>
    <div id="employed_gvt_type" style="display:none">
        <?php
        echo $form->field($model, 'employed_gvt_check_number_status')->label('Do you have check number or employee ID?')->radioList($list2,
            [
                'inline'=>true,
                'id'=>employed_gvt_check_number_status_id,
                'onchange'=>'setGvtCheckNumberEmployee(this)',
            ]);
        ?>
    </div>
    <br/>
    <div id="employed_show" style="display:none">
        <legend><small><strong>Provide the below Detail(s)</strong></small></legend>
        <div id="show_employername" style="display:none">
    <?php
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
        'columns'=>1,
        'id'=>'employment_detail_block_id',
        'attributes'=>[
            //'employer_name'=>['label'=>'Employer Name:', 'options'=>['placeholder'=>'Enter.','id' => 'employer_name_id']],
            'employer_name' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Employer Name:',
                'options' => [
                    'data' =>ArrayHelper::map(\frontend\modules\repayment\models\Employer::find()->asArray()->all(), 'employer_id', 'employer_name'),
                    'options' => [
                        'prompt' => 'Select',
                        'id' => 'employer_name_id',
                    ],
                ],
            ],
        ]
    ]);
    ?>
        </div>
        <?php
        echo Form::widget([ // fields with labels
            'model'=>$model,
            'form'=>$form,
            'columns'=>1,
            'attributes'=>[
                'employee_id'=>['label'=>'Employee ID/Check number:', 'options'=>['placeholder'=>'Enter.','id' => 'employeeID_id']],
                //'start_date'=>['label'=>'Start Date:', 'options'=>['placeholder'=>'Enter.','id' => 'start_date_id']],
                //'end_date'=>['label'=>'End Date:', 'options'=>['placeholder'=>'Enter.','id' => 'end_date_id']],
                //'slip_document'=>['label'=>'Salary/Pay Slip Document:', 'options'=>['placeholder'=>'Enter.','id' => 'slip_document_id']],
            ]
        ]);
        ?>
        <div id="employmentStatusV" style="display:none">
        <div class="text-right">
            <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
            echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", [$cancel], ['class' => 'btn btn-warning']);

            ActiveForm::end();
            ?>
        </div>

    </div>
    <br/></br/>
    <div class="rowQA" id="showBackNext" style="display:none">
        <div class="block pull-LEFT"><?= yii\helpers\Html::a("<< BACK",['site/index-employment-details']);?></div>
        <div class="block pull-RIGHT"><?= yii\helpers\Html::a("NEXT >>",['site/list-steps-nonbeneficiary','id'=>$refundClaimantid]);?></div>
    </div>
</div>
