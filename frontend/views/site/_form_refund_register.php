<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\PasswordInput;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundClaimant */
/* @var $form yii\widgets\ActiveForm */
/*
$nonbeneficiaryExplanation="Non-Beneficiary is the refund type for the students who where being deducted while are not loan beneficiary ewiuhdewuhduwedh iuewhduihweiuchwe ewiuhiwehdiweh ewiudhewuhduwe weiudhuwhdw weuydgwgduw whdwgdw uywgdwgd67w ";
$overdeductedExplanation="Over Deducted is the refund type for the students who where being deducted more amount than they are supposed to be deducted ewiuhdewuhduwedh iuewhduihweiuchwe ewiuhiwehdiweh ewiudhewuhduwe weiudhuwhdw weuydgwgduw whdwgdw uywgdwgd67w ";
$deceasedExplanation="Deceased is the refund type for the students who where being deducted while are no longer alive ewiuhdewuhduwedh iuewhduihweiuchwe ewiuhiwehdiweh ewiudhewuhduwe weiudhuwhdw weuydgwgduw whdwgdw uywgdwgd67w ";
*/
$nonbeneficiaryExplanation='Non-Beneficiary à Non-beneficiary refund type refers to the refund given to a claimant that was deducted but has never been a loan beneficiary of the HESLB';
$overdeductedExplanation='Over-deducted Loan Beneficiary à refers to the refund given to a claimant who has been deducted beyond what the HESLB owe the loan beneficiary. The deductions are usually beyond what they are to repay';
$deceasedExplanation='Deceased à refers to the refund given for a deceased either non-beneficiary or over-dedcuted beneficiary.';
$list2 = [1 => 'Confirm the Refund Type Selected!'];
?>
<script type="text/javascript">
    function ShowHideDiv() {
        var getValue = document.getElementById("refund_type_id");
        var refund_typeV= getValue.value;

        //alert (claim_category_value);
        if(refund_typeV=='1'){
            document.getElementById('refund_typeV_non_beneficiary').style.display = 'block';
            document.getElementById('refund_typeV_non_overdeducted').style.display = 'none';
            document.getElementById('refund_typeV_non_deceased').style.display = 'none';
        }
        else if(refund_typeV=='2'){
            document.getElementById('refund_typeV_non_overdeducted').style.display = 'block';
            document.getElementById('refund_typeV_non_beneficiary').style.display = 'none';
            document.getElementById('refund_typeV_non_deceased').style.display = 'none';

        }else if(refund_typeV=='3'){
            document.getElementById('refund_typeV_non_deceased').style.display = 'block';
            document.getElementById('refund_typeV_non_overdeducted').style.display = 'none';
            document.getElementById('refund_typeV_non_beneficiary').style.display = 'none';
        }else{
            document.getElementById('refund_typeV_non_deceased').style.display = 'none';
            document.getElementById('refund_typeV_non_overdeducted').style.display = 'none';
            document.getElementById('refund_typeV_non_beneficiary').style.display = 'none';
        }
    }
</script>

<div class="refund-claimant-form">
 <?php
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]);
?>
    <?php
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
        'columns'=>2,
        'attributes'=>[
            'firstname'=>['label'=>'First Name:', 'options'=>['placeholder'=>'First Name']],
            'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
            'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name']],
            //'phone_number'=>['label'=>'Phone #:', 'options'=>['placeholder'=>'Phone #']],
			
			'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => '0*********','data-toggle' => 'tooltip',
                'data-placement' => 'top', 'title' => 'Phone Number eg 07XXXXXXXX or 06XXXXXXXX or 0XXXXXXXXX']],
				
            'email'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address']],
            //'refund_type'=>['label'=>'Refund Type:', 'options'=>['placeholder'=>'Refund Type']],
            /*
            'refund_type'=>['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Refund Type:',

                'options' => [
                    'data' => ['1'=>'NON-BENEFICIARY', '2'=>'OVER DEDUCTED','3'=>'DECEASED'],
                    'options' => [
                        'prompt' => 'Select ',
                        'id' => 'refund_type_id',
                        'onchange'=>'ShowHideDiv()',

                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
            */
            'refund_type' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'label'=>'Refund Type:',
                'items' =>['1'=>'NON-BENEFICIARY', '2'=>'OVER DEDUCTED','3'=>'DECEASED'],
                'options' => [
                    'prompt' => 'Select',
                    'id' => 'refund_type_id',
                    'onchange'=>'ShowHideDiv()',
                ],
            ],
        ]
    ]);
    ?>
    <div id="refund_typeV_non_beneficiary" style="display:none">
        <legend><small><strong><em><?php echo $nonbeneficiaryExplanation; ?></em></strong></small></legend>
        <?php
        echo $form->field($model, 'refund_type_confirmed_nonb')->label(FALSE)->radioList($list2,
            [
                'inline'=>true,
                //'id'=>needNeedDenialLetter_id,
                //'onchange'=>'ShowFundStatus(this)',
            ]);
        ?>
    </div>
    <div id="refund_typeV_non_overdeducted" style="display:none">
        <legend><small><strong><em><?php echo $overdeductedExplanation; ?></em></strong></small></legend>
        <?php
        echo $form->field($model, 'refund_type_confirmed_overded')->label(FALSE)->radioList($list2,
            [
                'inline'=>true,
                //'id'=>needNeedDenialLetter_id,
                //'onchange'=>'ShowFundStatus(this)',
            ]);
        ?>
    </div>
    <div id="refund_typeV_non_deceased" style="display:none">
        <legend><small><strong><em><?php echo $deceasedExplanation; ?></em></strong></small></legend>
        <?php
        echo $form->field($model, 'refund_type_confirmed_deceased')->label(FALSE)->radioList($list2,
            [
                'inline'=>true,
                //'id'=>needNeedDenialLetter_id,
                //'onchange'=>'ShowFundStatus(this)',
            ]);
        ?>
    </div>
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
