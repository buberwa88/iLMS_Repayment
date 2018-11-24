<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Templates */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="templates-form">

    <?php  $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); ?>
    <?php
        echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'template_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Template Name...', 'maxlength' => 500]],
            'template_status' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=>['1'=>'Active','2'=>'Inactive'],  'options' => ['prompt' => 'select status']],

        ]
    ]);

    ?>

    <?php  echo $form->field($model, 'template_content')->widget(CKEditor::className(), [
        'options' => ['rows' => 1],
        'preset' => 'custom',
         'clientOptions' => [
                    'filebrowserUploadUrl' => 'site/url',
                     'toolbarGroups' => [
                     ['name' => 'document', 'groups' => ['mode', 'document', 'doctools' ]],
                     ['name' => 'clipboard', 'groups' => ['clipboard', 'undo' ]],
                     ['name' => 'editing', 'groups' => ['find', 'selection', 'spellchecker' ]],
                    '/',
                     ['name' => 'basicstyles', 'groups' => ['basicstyles', 'cleanup' ]],
                     ['name' => 'paragraph', 'groups' => ['list', 'indent', 'blocks', 'align', 'bidi' ]],
                     ['name' => 'links'],
                     ['name' => 'insert'],
                     '/',
                     ['name' => 'styles'],
                     ['name' => 'colors'],
                     ['name' => 'tools'],
                     ['name' => 'others']
                  ],
                ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

