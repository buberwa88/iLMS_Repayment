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
    echo Form::widget([ // fields with labels
        'model'=>$model,
        'form'=>$form,
        'columns'=>1,
        'attributes'=>[
            'study_level' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Level of study:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                    'options' => [
                        'prompt' => 'Select',
                        //'id' => 'applicant_category_id',

                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
            'institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution:',
                'options' => [
                    'data' => ArrayHelper::map(\frontend\modules\application\models\LearningInstitution::find()->where(['institution_type' => ['UNIVERSITY', 'COLLEGE']])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => ' Select Learning Institution ',
                        'id' => 'learning_institution_PhD_id',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
            'program_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Programme Studied:',
                'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\Programme::find()->all(), 'programme_id', 'programme_name'),
                    'options' => [
                        'prompt' => ' Select Programme ',
                        'id' => 'programme_PhD_id',
                    ],
                    'pluginOptions' => [
                        'depends' => ['learning_institution_PhD_id'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/repayment/employer/programme-namepublic']),
                    ],
                ],
            ],
            'entry_year'=>['label'=>'Entry Year:', 'options'=>['placeholder'=>'Entry Year','id' => 'programme_entry_year_PhD_id']],
            'completion_year'=>['label'=>'Completion Year:', 'options'=>['placeholder'=>'Completion Year','id' => 'programme_completion_year_PhD_id']],
        ]
    ]);
    ?>
    <?php
    echo $form->field($model, 'certificate_document')->label('Certificate Document:')->widget(FileInput::classname(), [
        'options' => ['accept' => 'site/pdf'],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => TRUE,
            'showUpload' => false,
            // 'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
            'browseLabel' =>  'Certificate Document (required format .pdf only)',
            'initialPreview'=>[
                "$model->certificate_document",

            ],
            'initialCaption'=>$model->certificate_document,
            'initialPreviewAsData'=>true,
        ],
        //'hint'=>'<i>Provide the first latest Salary/Pay Slip Document</i>',
    ]);
    ?>


    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['site/index-tertiary-education','id'=>$employerID], ['class' => 'btn btn-warning']);

        ActiveForm::end();
        ?>
    </div>
</div>
