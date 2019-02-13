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

    function ShowemployementDetails(element){
        //alert(element);
        var employmentStatusV=$('#employmentStatus_id input:checked').val();
        if (employmentStatusV==1) {
            document.getElementById('employed_show').style.display = 'block';
            document.getElementById('employment_detail_block_id').style.display = 'block';
            //document.getElementById('payment_slip_doc_block_id').style.display = 'block';
            $('#employer_name_id').attr('style', 'display:block');
            $('#employeeID_id').attr('style', 'display:block');
            $('#start_date_id').attr('style', 'display:block');
            $('#end_date_id').attr('style', 'display:block');
            document.getElementById('showBackNext').style.display = 'none';
            //$('#second_slip_document_id').attr('style', 'display:block');
            //$('#first_slip_document_id').attr('style', 'display:block');
        } else if(employmentStatusV==2){
            document.getElementById('employed_show').style.display = 'block';
            document.getElementById('employment_detail_block_id').style.display = 'none';
            //document.getElementById('payment_slip_doc_block_id').style.display = 'block';
            $('#employer_name_id').val('');
            $('#employeeID_id').val('');
            $('#start_date_id').val('');
            $('#end_date_id').val('');
            $('#employer_name_id').attr('style', 'display:none');
            $('#employeeID_id').attr('style', 'display:none');
            $('#start_date_id').attr('style', 'display:none');
            $('#end_date_id').attr('style', 'display:none');
            document.getElementById('showBackNext').style.display = 'none';
            //$('#second_slip_document_id').attr('style', 'display:block');
            //$('#first_slip_document_id').attr('style', 'display:block');
        }else {
            // reset values
            $('#employer_name_id').val('');
            $('#employeeID_id').val('');
            $('#start_date_id').val('');
            $('#end_date_id').val('');
            //$('#first_slip_document_id').val('');
            //$('#second_slip_document_id').val('');
            document.getElementById('employed_show').style.display = 'none';
            document.getElementById('showBackNext').style.display = 'block';
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
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data']]);
    ?>
    <?php
    echo $form->field($model, 'employment_status')->label('Have you ever been Employed?')->radioList($list,
        [
        'inline'=>true,
        'id'=>employmentStatus_id,
        'onchange'=>'ShowemployementDetails(this)',
        ]);
    ?>
    <br/>
    <div id="employed_show" style="display:none">
        <legend><small><strong>Provide the below Detail(s)</strong></small></legend>
    <?php
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
        'columns'=>1,
        'id'=>'employment_detail_block_id',
        'attributes'=>[
            'employer_name'=>['label'=>'Employer Name:', 'options'=>['placeholder'=>'Enter.','id' => 'employer_name_id']],
            'employee_id'=>['label'=>'Employee ID/Check number:', 'options'=>['placeholder'=>'Enter.','id' => 'employeeID_id']],
            //'start_date'=>['label'=>'Start Date:', 'options'=>['placeholder'=>'Enter.','id' => 'start_date_id']],
            //'end_date'=>['label'=>'End Date:', 'options'=>['placeholder'=>'Enter.','id' => 'end_date_id']],
            //'slip_document'=>['label'=>'Salary/Pay Slip Document:', 'options'=>['placeholder'=>'Enter.','id' => 'slip_document_id']],
        ]
    ]);
    ?>
        <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
            'name' => 'start_date',
            //'value' => date('Y-m-d', strtotime('+2 days')),

            'options' => ['placeholder' => 'yyyy-mm-dd',
                'todayHighlight' => false,
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => false,
            ],
        ]);
        ?>
        <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
            'name' => 'end_date',
            //'value' => date('Y-m-d', strtotime('+2 days')),

            'options' => ['placeholder' => 'yyyy-mm-dd',
                'todayHighlight' => false,
            ],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => false,
            ],
        ]);
        ?>
        <?php
        echo $form->field($model, 'first_slip_document')->label('Salary/Pay Slip Document:')->widget(FileInput::classname(), [
            'options' => ['accept' => 'site/pdf'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => TRUE,
                'showUpload' => false,
                // 'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                'browseLabel' =>  'Salary/Pay Slip Document (required format .pdf only)',
                'initialPreview'=>[
                    "$model->first_slip_document",

                ],
                'initialCaption'=>$model->first_slip_document,
                'initialPreviewAsData'=>true,
            ],
            //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
        ])->hint('Provide the first latest Salary/Pay Slip Document');
        ?>
        <?php
        echo $form->field($model, 'second_slip_document')->label('Salary/Pay Slip Document:')->widget(FileInput::classname(), [
            'options' => ['accept' => 'site/pdf'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => TRUE,
                'showUpload' => false,
                // 'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                'browseLabel' =>  'Salary/Pay Slip Document (required format .pdf only)',
                'initialPreview'=>[
                    "$model->second_slip_document",

                ],
                'initialCaption'=>$model->second_slip_document,
                'initialPreviewAsData'=>true,
            ],
            //'hint'=>'<i>Provide the second latest Salary/Pay Slip Document</i>',
        ])->hint('Provide the second latest Salary/Pay Slip Document');
        ?>
        <div class="text-right">
            <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
            echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['site/index-employment-details'], ['class' => 'btn btn-warning']);

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
