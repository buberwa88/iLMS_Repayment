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
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,]);
    ?>
    <?php
    echo Form::widget([ // fields with labels
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'study_level' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Level of study:',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\ApplicantCategory::find()->all(), 'applicant_category_id', 'applicant_category'),
                    'options' => [
                        'prompt' => '-- Select --',
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
                        'prompt' => '-- Select Institution -- ',
                        'id' => 'learning_institution_id',
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
                        'prompt' => '-- Select Programme -- ',
                        'id' => 'programme_id',
                    ],
                    'pluginOptions' => [
                        'depends' => ['learning_institution_id'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/repayment/employer/programme-namepublic']),
                    ],
                ],
            ],
            'institution_name' => ['type' => Form::INPUT_TEXT,
                'label' => 'Institution/Univeristy Name:',
                'options' => [
                    'prompt' => ' Enter Institution Name ',
                    'id' => 'institution_name',
                ],
            ],
            'programme_name' => ['type' => Form::INPUT_TEXT,
                'label' => 'Programme Name:',
                'options' => [
                    'prompt' => ' Enter Programme Name ',
                    'id' => 'programme_name',
                ],
            ],
            'entry_year' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Entry Year:',
                'options' => [
                    'data' => \common\components\Calendar::getNYearsListfromCurrentYear(100),
                    'options' => [
                        'prompt' => '-- select -- ',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
            'completion_year' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Completion Year:',
                'options' => [
                    'data' => \common\components\Calendar::getNYearsListfromCurrentYear(100),
                    'options' => [
                        'prompt' => '-- select -- ',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
        ]
    ]);
    ?>


    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

        <?php
        echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", ['site/index-tertiary-education', 'id' => $employerID], ['class' => 'btn btn-warning']);

        ActiveForm::end();
        ?>
    </div>
</div>


<?php
/////JQUERY SCRIPTS
$this->registerJs('
$( document ).ready(function() {
var others=$("#select2-learning_institution_id-container").attr("title");
if(others=="Others" || others=="Other"){
$("#institution_name").show();
$("#programme_name").show();
$(".field-institution_name").show();
$(".field-programme_name").show();

$("#learning_institution_id").hide();
$(".programme_id").hide();
$(".field-refundclaimanteducationhistory-program_id").hide();

}else{
$(".programme_id").show();
$(".field-refundclaimanteducationhistory-program_id").show();

$("#institution_name").hide();
$("#programme_name").hide();
$(".field-institution_name").hide();
$(".field-programme_name").hide();
}
});


$("#learning_institution_id").change(function () {
var others=$("#select2-learning_institution_id-container").attr("title");
if(others=="Others" || others=="Other"){
$("#institution_name").show();
$("#programme_name").show();
$(".field-institution_name").show();
$(".field-programme_name").show();

$("#learning_institution_id").hide();
$(".programme_id").hide();
$(".field-refundclaimanteducationhistory-program_id").hide();

}else{
$(".programme_id").show();
$(".field-refundclaimanteducationhistory-program_id").show();

$("#institution_name").hide();
$("#programme_name").hide();
$(".field-institution_name").hide();
$(".field-programme_name").hide();
}

});

');
?>