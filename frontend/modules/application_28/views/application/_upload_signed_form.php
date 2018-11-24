<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Url;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Upload Signed Loan Application Form Pages: ';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = 'Upload';
?>
 
<div class="education-create">
      <div class="panel panel-info">
        <div class="panel-heading">
         <?= Html::encode($this->title) ?>  
        </div>
        <div class="panel-body">
<div class="classes-form">
 <?php
    $form = ActiveForm::begin(
                    ['type' => ActiveForm::TYPE_VERTICAL,
                        'options' => ['enctype' => 'multipart/form-data'] // important
                    ]
    );
    ?>
    <?php //echo $form->errorSummary($model);?>
    <?php

    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'page_number_two' => [
                'type' => Form::INPUT_WIDGET, 'widgetClass' => FileInput::className(),
                ['options' => ['accept' => 'application/pdf']],
                'pluginOptions' => ['showCaption' => false,
                        'showRemove' => TRUE,
                        'showUpload' => false,
                         'previewFileType' => 'image','allowedFileExtensions'=>['pdf']]
            ],
            'page_number_five' => [
                'type' => Form::INPUT_WIDGET, 'widgetClass' => FileInput::className(),
                ['options' => ['accept' => 'application/pdf']],
                'pluginOptions' => [
                      'showCaption' => false,
                        'showRemove' => TRUE,
                        'showUpload' => false,
                    'previewFileType' => 'image','allowedFileExtensions'=>['pdf'],                
                    ]
            ],
        ]
    ]);


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', '>> Submit') : Yii::t('app', 'Submit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']);
    ActiveForm::end();
    ?>

</div>
        </div>
      </div>
</div>
