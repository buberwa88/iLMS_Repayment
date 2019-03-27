<script type="text/javascript">
     function claimantNamesChangedStatus(element) {//
        var namesChangedStatusV = $('#claimant_names_changed_status_id input:checked').val();
        if (namesChangedStatusV == 1) {
            $('.field-refundApplication-deed_pole_document').attr('style', 'display:block');
            // $('#form_data_id').attr('style', 'display:block');
        }
        else {
            $('#deed_pole_document_id').val('');
            $('.field-refundApplication-deed_pole_document').attr('style', 'display:none');
        }
    }
</script>
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
    //$nonenecta = "checked='checked'";
    if ($model->claimant_names_changed_status==1) {
        //$nonenecta = "checked='checked'";
        echo '<style>
        .field-refundApplication-deed_pole_document{
            display:block;
        }
    </style>';
    } else {
        echo '<style>
      .field-refundApplication-deed_pole_document{
            display: none;
        }
    </style>';
    }

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\RefundEducationHistory */
/* @var $form yii\widgets\ActiveForm */
$list = [1 => 'Yes', 2 => 'No'];
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
$resultsCheckResultsGeneral = RefundApplication::getStageCheckedApplicationGeneral($refund_application_id);
$refundTypeId = $resultsCheckResultsGeneral->refund_type_id;

if ($refundTypeId == 3) {
    $bankAttLabe = "Court Bank Account Document:";
    $hint="Weka kiambatanisho chenye account ya bank kilichothibitishwa na mahakama";
} else {
    $bankAttLabe = "Bank Card Document:";
    $hint="";
}

$cancel = "site/refund-liststeps";
?>
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
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,]);
    ?>
    <?php
    echo Form::widget([ // fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'bank_name' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Bank Name',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Bank::find()->all(), 'bank_name', 'bank_name'),
                    'options' => [
                        'prompt' => '-- Select Bank -- ',
                        //'id' => 'learning_institution_id',
                    ],
                ],
            ],
            'branch' => ['label' => 'Branch:', 'options' => ['placeholder' => 'Enter Branch Name']],
            'bank_account_number' => ['label' => 'Account Number:', 'options' => ['placeholder' => 'Enter Bank Account Number.']],
            'bank_account_name' => ['label' => 'Account Name:', 'options' => ['placeholder' => 'Enter Bank Account Name.']],
        ]
    ]);
    ?>
    <?php
    echo $form->field($model, 'bank_card_document')->label($bankAttLabe)->widget(FileInput::classname(), [
        'options' => ['accept' => 'site/pdf'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => TRUE,
            'showUpload' => false,
            // 'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
            'browseLabel' => $bankAttLabe . ' (required format .pdf only)',
            'initialPreview' => [
                "$model->bank_card_document",
            ],
            'initialCaption' => $model->bank_card_document,
            'initialPreviewAsData' => true,
            'initialPreviewConfig' => [
                ['type'=> explode(".",$model->bank_card_document)[1]=="pdf"?"pdf":"image"],
            ],
        ],
            //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
    ])->hint($hint);
    ?>
    <?php if ($refundTypeId != 3) { ?>
        <?php
        echo $form->field($model, 'claimant_names_changed_status')->label('Have you changed you names?')->radioList($list, [
            'inline' => true,
            'id' => claimant_names_changed_status_id,
            'onchange' => 'claimantNamesChangedStatus(this)',
        ]);
        ?>
    <?php } ?>
    <br/>
    <?= $form->field($model, 'refundType')->label(FALSE)->hiddenInput(["value" => $refundTypeId, 'id' => 'refundType_id']) ?>
    <br/>
        <?php
        echo $form->field($model, 'deed_pole_document')->label('Deed Pole Document:')->widget(FileInput::classname(), [
            'options' => ['accept' => 'site/pdf','id' => 'deed_pole_document_id',],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => TRUE,
                'showUpload' => false,
                // 'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                'browseLabel' => 'Deed Pole Document (required format .pdf only)',
                'initialPreview' => [
                    "$model->deed_pole_document",
                ],
                'initialCaption' => $model->deed_pole_document,
                'initialPreviewAsData' => true,
                'initialPreviewConfig' => [
                    ['type'=> explode(".",$model->deed_pole_document)[1]=="pdf"?"pdf":"image"],
                ],
            ],
                //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
        ]);
        ?>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", [$cancel], ['class' => 'btn btn-warning']);

        ActiveForm::end();
        ?>
    </div>
</div>
