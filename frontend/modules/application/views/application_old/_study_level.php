<script>
      function check_level() {//
        var status = document.getElementById('application-applicant_category_id').value;
           if (status == 2 ||status==4||status==5) {
                  $('.field-application-admission_letter').attr('style', 'display:block');
                  $('.field-application-employer_letter').attr('style', 'display:block'); 
             }
        else {
           $('.field-application-admission_letter').attr('style', 'display:none');
           $('.field-application-employer_letter').attr('style', 'display:none'); 
        }
    }
</script>
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\User */
/* @var $form yii\widgets\ActiveForm */
 if ($model->applicant_category_id==2 ||$model->applicant_category_id==4||$model->applicant_category_id==5) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        .field-application-admission_letter,.field-application-employer_letter{
            display:block;
        }
    </style>';
} else {
    echo '<style>
      .field-application-admission_letter,.field-application-employer_letter{
            display: none;
        }
    </style>';
}
?>

<div class="user-form">
    <?php
      $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,
    ]);
       //$model->loanee_category="";
       echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' =>1,
            'attributes' => [
        'loanee_category' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Applicant  Category',
                'options' => [
                    'data' =>["Local"=>"Local (Wanaotarajia kusoma vyuo vya ndani ya nchi (Tanzania))","Overseas"=>"OverSeas (Wanaotarajia kusoma vyuo vya nje ya nchi)"],
                    'options' => [
                        'prompt' => 'Select Applicant Category',
                        
                    ],
                ],
            ],
        'applicant_category_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Study Level',
                'options' => [
                    'data' => ArrayHelper::map(\backend\modules\application\models\ApplicantCategory::find()->where("applicant_category_id<>3")->all(), 'applicant_category_id', 'applicant_category'),
                    'options' => [
                        'prompt' => 'Select Study Level',
                         'onchange' => 'check_level()',
                        
                    ],
                ],
            ],
           
           ]
           ]);
      echo $form->field($model, 'admission_letter')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
    'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' => 'Attach Admission Letter (format required is pdf only )',
        'initialPreview' => [
            "$model->admission_letter",
        ],
        'initialCaption' =>admission_letter,
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => [
            ['type'=>explode(".",$model->admission_letter)[1]=="pdf"?"pdf":"image"],
        ],
    ]
]);
echo $form->field($model, 'employer_letter')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
    'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' => 'Attach Employer Letter (format required is pdf only)',
        'initialPreview' => [
            "$model->employer_letter",
        ],
        'initialCaption' =>$model->employer_letter,
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => [
            ['type'=>explode(".",$model->employer_letter)[1]=="pdf"?"pdf":"image"],
        ],
    ]
]);
        ?>
   
             <div class="text-right">

            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
            ?>
            <?= Html::a('Cancel', ['study-view'], ['class' => 'btn btn-warning']) ?>
<?php
ActiveForm::end();
//print_r($model->errors);
?>

            </div>
        </div>
