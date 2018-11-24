<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="education-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'application_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Application ID...']],

            'level' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Level...']],

            'registration_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Registration Number...', 'maxlength' => 40]],

            'entry_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Entry Year...']],

            'completion_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Completion Year...']],

            'avn_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Avn Number...', 'maxlength' => 40]],

            'learning_institution_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Learning Institution ID...']],

            'division' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Division...']],

            'is_necta' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Is Necta...']],

            'under_sponsorship' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Under Sponsorship...']],

            'alevel_index' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Alevel Index...']],

            'points' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Points...']],

            'gpa_or_average' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Gpa Or Average...']],

            'programme_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Programme Name...', 'maxlength' => 70]],

            'programme_code' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Programme Code...', 'maxlength' => 20]],

            'class_or_grade' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Class Or Grade...', 'maxlength' => 20]],

            'olevel_index' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Olevel Index...', 'maxlength' => 20]],

            'sponsor_proof_document' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Sponsor Proof Document...', 'maxlength' => 200]],

            'institution_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Institution Name...', 'maxlength' => 50]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
