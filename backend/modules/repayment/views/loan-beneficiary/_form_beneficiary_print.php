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

/* @var $this yii\web\View */
/* @var $model frontend\modules\repayment\models\Employer */
/* @var $form yii\widgets\ActiveForm */
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'enableClientValidation' => TRUE, 'action' => ['/report/report/print-report-students'], 'options' => ['method' => 'post', 'target' => '_blank']]);
?>
<div class='form-group' style="margin: 0;padding: 2%;">
    <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [ // 2 column layout
            'exportCategory' => [
                'type' => Form::INPUT_HIDDEN,
                'label' => false,
                'options' => [
                    'readonly' => TRUE,
                    'value' => 1
                ],
            ],
            'applicant_id' => [
                'type' => Form::INPUT_HIDDEN,
                'label' => false,
                'options' => [
                    'readonly' => TRUE,
                    'value' => $model->applicant_id
                ],
            ], 'pageIdentifyStud' => [
                'type' => Form::INPUT_HIDDEN,
                'label' => false,
                'options' => [
                    'readonly' => TRUE,
                    'value' => 1
                ],
            ],
            'uniqid' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => false,
                'options' => [
                    'data' => ArrayHelper::map(\backend\modules\report\models\Report::findBySql('SELECT id,name FROM report WHERE student_printview=1')->asArray()->all(), 'id', 'name'),
                    'options' => [
                        'prompt' => '--Choose Print Item--',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ],
            ],
        ]
    ]);
    ?>
    <?= $form->field($model, 'export_mode')->label(false)->dropDownList([ '1' => 'Landscape', '2' => 'Portrait'], ['prompt' => 'Select Export Mode']) ?>			
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Generate' : 'Generate', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>