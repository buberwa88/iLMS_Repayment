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
$session = Yii::$app->session;
$refundClaimantid = $session->get('refund_claimant_id');
$refund_application_id = $session->get('refund_application_id');
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
    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL,'options' => ['enctype' => 'multipart/form-data'],
        'enableClientValidation' => TRUE,]);
    ?>
    <?php
    echo $form->field($model, 'letter_family_session_document')->label('Family Session Letter Document:')->widget(FileInput::classname(), [
        'options' => ['accept' => 'site/pdf'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => TRUE,
            'showUpload' => false,
            // 'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
            'browseLabel' =>  'Family Session Letter Document (required format .pdf only)',
            'initialPreview'=>[
                "$model->letter_family_session_document",

            ],
            'initialCaption'=>$model->letter_family_session_document,
            'initialPreviewAsData'=>true,
        ],
        //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
    ]);
    ?>
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
        <div class="text-right">
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
            echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['site/list-steps-deceased'], ['class' => 'btn btn-warning']);

            ActiveForm::end();
            ?>
        </div>
</div>
