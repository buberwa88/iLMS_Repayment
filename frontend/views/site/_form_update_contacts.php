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

$incomplete=0;
$cancel='index-contactdetails';
//$this->title ='Application for Refund, Select the Refund Type:';
//$this->params['breadcrumbs'][] = 'Refund Application';
$model->claimant_letter_document=$model->refundApplication->claimant_letter_document;
?>
<div class="education-create">
    <div class="panel panel-info">
        <div class="panel-body">
            <div class="col-lg-12">
                <?php
                $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'options' => ['enctype' => 'multipart/form-data'],
                    'enableClientValidation' => TRUE,
                ]);
                ?>
                    <?php
                    echo Form::widget([ // fields with labels
                        'model'=>$model,
                        'form'=>$form,
                        'columns'=>2,
                        'attributes'=>[
                            'firstname'=>['label'=>'First Name:','options'=>['placeholder'=>'First Name']],
                            'middlename'=>['label'=>'Middle Name:', 'options'=>['placeholder'=>'Middle Name']],
                            'surname'=>['label'=>'Last Name:', 'options'=>['placeholder'=>'Last Name']],
                            //'phone_number'=>['label'=>'Phone #:', 'options'=>['placeholder'=>'Phone #']],
                            'email_address'=>['label'=>'Email Address:', 'options'=>['placeholder'=>'Email Address']],
                            'phone_number' => ['label'=>'Phone Number:','type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => '0*********','data-toggle' => 'tooltip',
                                'data-placement' => 'top', 'title' => 'Phone Number eg 07XXXXXXXX or 06XXXXXXXX or 0XXXXXXXXX']],
                        ]
                    ]);
                    ?>
                <?php
                echo $form->field($model, 'claimant_letter_document')->label('Refund application letter document:')->widget(FileInput::classname(), [
                    'options' => ['accept' => 'site/pdf'],
                    'pluginOptions' => [
                        'showCaption' => false,
                        'showRemove' => TRUE,
                        'showUpload' => false,
                        // 'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
                        'browseLabel' =>  'Refund application letter document (required format .pdf only)',
                        'initialPreview'=>[
                            "$model->claimant_letter_document",

                        ],
                        'initialCaption'=>$model->claimant_letter_document,
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => [
                            ['type'=> explode(".",$model->claimant_letter_document)[1]=="pdf"?"pdf":"image"],
                        ],
                    ],

                ]);
                ?>
                    <div class="text-right">
                        <?= Html::submitButton($model->isNewRecord ? 'Update' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

                        <?php
                        echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
                        echo Html::a("Cancel&nbsp;&nbsp;<span class='label label-warning'></span>", [$cancel], ['class' => 'btn btn-warning']);

                        ActiveForm::end();
                        ?>
                    </div>
            </div>
        </div>
    </div>
</div>