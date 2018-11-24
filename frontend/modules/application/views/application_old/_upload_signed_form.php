<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use frontend\modules\application\models\Applicant;
use frontend\modules\application\models\Application;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Upload Signed Loan Application Form Pages: ';
$this->params['breadcrumbs'][] = ['label' => 'My Application', 'url' => ['default/my-application-index']];
$this->params['breadcrumbs'][] = 'Upload';
$user_id = Yii::$app->user->identity->id;
$modelApplicant = Applicant::find()->where("user_id = {$user_id}")->one();
$modelApplication = Application::find()->where("applicant_id = {$modelApplicant->applicant_id}")->one();
$applicant_category=$modelApplication->applicant_category_id>0?$modelApplication->applicantCategory->applicant_category:"";

?>
 
<div class="education-create">
      <div class="panel panel-info">
        <div class="panel-heading">
      Step 12 : <?= Html::encode($this->title) ?><label class="pull-right" style="font-size:16px"><?=$modelApplication->loanee_category." ".$applicant_category;?></label>
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
echo $form->field($model, 'page_number_two')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
        'fileActionSettings' => [
            'showZoom' => false,
            ],
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        'previewFileType' => 'image','allowedFileExtensions'=>['pdf'],
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Page Number Two  (required format .pdf only)',
     
    ]
]);

echo $form->field($model, 'page_number_five')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
        'fileActionSettings' => [
            'showZoom' => false,
            ],
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        'previewFileType' => 'image','allowedFileExtensions'=>['pdf'],
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Page Number Five (required format .pdf only)',
        
    ]
]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Upload') : Yii::t('app', 'Upload'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']);
    ActiveForm::end();
    ?>

</div>
        </div>
      </div>
</div>

