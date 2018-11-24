<script>
    function check_guarantor() {//
        var status = document.getElementById('guarantor-guarantor_type').value;
        if (status == 1) {
            $('.field-guarantor-organization_type').attr('style', 'display:block');
            $('#form_data_id').attr('style', 'display:none');
            $('.field-guarantor-learning_institution_id').attr('style', 'display:none');
            $('.field-organization_name_id').attr('style', 'display:none');
            $('.field-guarantor-passport_photo').attr('style', 'display:none');
            $('#identification_form_id').attr('style', 'display:none');
        }
        else if (status >1) {
            //identification_form_id
            $('.field-guarantor-organization_type').attr('style', 'display:none');
            $('#form_data_id').attr('style', 'display:none');
            $('.field-guarantor-learning_institution_id').attr('style', 'display:none');
            $('.field-organization_name_id').attr('style', 'display:none');
            $('.field-organization_name_id').attr('style', 'display:none');
            $('.field-guarantor-passport_photo').attr('style', 'display:block');
                $('#identification_form_id').attr('style', 'display:block');
               $('.field-guarantor-identification_document').attr('style', 'display:block');
        }
       else {
            $('#form_data_id').attr('style', 'display:none');
            $('.field-guarantor-learning_institution_id').attr('style', 'display:none');
            $('.field-organization_name_id').attr('style', 'display:none');
            $('.field-guarantor-organization_type').attr('style', 'display:none');
            $('.field-guarantor-passport_photo').attr('style', 'display:none');
            $('#identification_form_id').attr('style', 'display:none');
            $('.field-guarantor-identification_document').attr('style', 'display:none');
        }
    }
    function check_organization() {//
        var status = document.getElementById('guarantor-organization_type').value;
        if (status == 1) {
            $('.field-guarantor-learning_institution_id').attr('style', 'display:block');
            $('.field-organization_name_id').attr('style', 'display:none');
            $('#form_data_id').attr('style', 'display:none');
        }
        else   if (status>1) {
            $('#form_data_id').attr('style', 'display:block');
            $('.field-guarantor-learning_institution_id').attr('style', 'display:none');
            $('.field-organization_name_id').attr('style', 'display:block');
        }
          else{
          $('#form_data_id').attr('style', 'display:none');
           $('.field-guarantor-learning_institution_id').attr('style', 'display:none');
           $('.field-organization_name_id').attr('style', 'display:none');     
        }
   
    }
</script>
<style>
    #identification_form_id ,#form_data_id,.field-guarantor-identification_document ,.field-guarantor-passport_photo,.field-guarantor-organization_type,.field-guarantor-learning_institution_id ,.field-organization_name_id {
        display: none;
        //text-align: center;
    }
</style> 
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
   /*
     * check applicant category
     */
          if($modelApplication->applicant_category_id==2){
             $model->guarantor_type=1;  
             $guarant_array=[ 1 => 'Organization'];
          }
          else{
              /*
               * check if parent are alive
               */
              $model_father=\frontend\modules\application\models\ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND is_parent_alive='YES' AND guarantor_type is NULL AND sex='M'")->count();
              $model_mother=\frontend\modules\application\models\ApplicantAssociate::find()->where("application_id = {$modelApplication->application_id} AND type = 'PR' AND is_parent_alive='YES' AND guarantor_type is NULL AND sex='F'")->count();
                      $parent=$parentm=array();
                     if($model_father>0){
                        $parent=[2 => 'Father'];   
                        }
                      if($model_mother>0){
                       $parentm=[ 3 => 'Mother'];     
                        }
                        $parentg=[4 => 'Guardian'];
              $guarant_array=$parent+$parentm+$parentg;   
          }
    /*
     * end check
     */
if ($model->learning_institution_id > 0 && $model->guarantor_type == 1) {
    $model->organization_type = 1;
} else if ($model->learning_institution_id == "" && $model->guarantor_type == 1&&$model->organization_name!="") {
    $model->organization_type = 2;
}
if (!$model->isNewRecord && $model->ward_id > 0) {
    $modelz = \backend\modules\disbursement\models\Ward::findOne($model->ward_id);

    $model->district_id = $modelz->district_id;
    ################find region Id ##############

    $modelr = \common\models\District::findOne($modelz->district_id);
    $model->region_id = $modelr->region_id;
}
if ($model->guarantor_type>1 && $model->guarantor_type != NULL) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        .field-guarantor-organization_type, .field-guarantor-learning_institution_id{
            display:none;
        }
    </style>';
     echo '<style>
     .field-guarantor-passport_photo,#w2,#identification_form_id,.field-guarantor-identification_document{
            display:block;
        }
    </style>';
} else {
    echo '<style>
      #form_data_id ,.field-guarantor-passport_photo,#w2{
            display: none;
        }
    </style>';
}
if ($model->guarantor_type == 1 && $model->guarantor_type != NULL) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        .field-guarantor-guarantor_type{
            display:none;
        }
    </style>';
    echo '<style>
        .field-guarantor-organization_type,.field-guarantor-organization_type,#w2{
            display:block;
        }
         .field-guarantor-passport_photo ,.field-guarantor-identification_document{
            display:none;
        }
    </style>';
}
if ($model->learning_institution_id > 0 && $model->learning_institution_id != NULL) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        .field-guarantor-learning_institution_id{
            display:block;
        }
    </style>';
} 
if ($model->organization_type == 2 && $model->organization_type != NULL) {
  echo '<style>
      #form_data_id{
            display:block;
        }
  
    </style>';
}

?>
<div class="education-form">
    <?php
  
      $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                 
                 'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,
    ]);
   
    ?>
    <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'guarantor_type' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'label' => "Guarantor  ",
                'items' => $guarant_array,
                'options' => [
                    'prompt' => 'Select  Guarantor ',
                    'onchange' => 'check_guarantor()',
                ],
            ]
        ]
    ]);
    echo $form->field($model, 'passport_photo')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
         'showCaption' => false,
        'showRemove' => TRUE,
        'showUpload' => false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-camera"></i> ',
        'browseLabel' =>  'Attach Guarantor Passport Photo',
             'initialPreview'=>[
            "$model->file_path$model->passport_photo",
           
        ],
        'initialCaption'=>$model->file_path.$model->passport_photo,
        'initialPreviewAsData'=>true,
         
    ]
]);
    
         echo Form::widget([
            'model' => $model,
            'form' => $form,
            'id'=>"identification_form_id",
            'columns' =>2,
            'attributes' => [
                'identification_type_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Identification Type',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\IdentificationType::find()->all(), 'identification_type_id', 'identification_type'),
                    'options' => [
                        'prompt' => 'Select Identification Type',
                         
                    ],
                ],
            ],
           'NID' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
            
         ]
        ]);

     echo $form->field($model, 'identification_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => TRUE,
        'showUpload' => false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Identification Document',
         'initialPreview'=>[
            "$model->identification_document",
           
        ],
        'initialCaption'=>$model->identification_document,
        'initialPreviewAsData'=>true,
    ]
]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'organization_type' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'label' => "Organization Type ",
                'items' => [1 => 'Academic', 2 => 'Non-Academic',3 => 'Other',],
                'options' => [
                    'prompt' => 'Select  Organization Type',
                    'onchange' => 'check_organization()',
                ],
            ]
        ]
    ]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'learning_institution_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Learning Institution',
                'options' => [
                    'data' => ArrayHelper::map(backend\modules\application\models\LearningInstitution::find()->where(["institution_type" => "UNIVERSITY"])->all(), 'learning_institution_id', 'institution_name'),
                    'options' => [
                        'prompt' => 'Select Learning Institution',
                        'id' => 'learning_institution_id'
                    ],
                ],
            ],
        ]
    ]);
    echo "<div id='form_data_id'>";
    ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            Organization Details
        </div>
        <div class="panel-body"> 
<?php
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'organization_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'id' => 'organization_name_id']],
    ]
]);


echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => '075*******']],
        'postal_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
        'physical_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
        'email_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => ' ']],
        'region_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Region',
            'options' => [
                'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                'options' => [
                    'prompt' => 'Select Region Name',
                    'id' => 'region_Id'
                ],
            ],
        ],
        'district_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'District',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(\common\models\District::find()->where(['region_id' => $model->region_id])->all(), 'district_id', 'district_name'),
                'options' => [
                    'prompt' => 'Select District Name',
                    'id' => 'district_id'
                ],
                'pluginOptions' => [
                    'depends' => ['region_Id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/application/district/district-name']),
                ],
            ],
        ],
        'ward_id' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Ward',
            'widgetClass' => DepDrop::className(),
            'options' => [
                'data' => ArrayHelper::map(backend\modules\application\models\Ward::find()->where(['district_id' => $model->district_id])->all(), 'ward_id', 'ward_name'),
                //'disabled' => $model->isNewrecord ? false : true,
                'pluginOptions' => [
                    'depends' => ['district_id'],
                    'placeholder' => 'Select ',
                    'url' => Url::to(['/application/district/ward-name']),
                ],
            ],
        ],
    ]
]);
?>
        </div>
    </div>
    <div class="panel panel-info">
        <div class="panel-heading">
            Contact Person Details
        </div>
        <div class="panel-body"> 
<?php
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'id' => "mickidadi12",
    'attributes' => [
        'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
        'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
        'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter ']],
        'sex' => [
            'type' => Form::INPUT_DROPDOWN_LIST,
            'items' => ['M' => 'Male', 'F' => 'Female'],
            'prompt' => 'Select Gender',
        ],
    ]
]);
echo "</div></div></div>";
?>
            <?= $form->field($model, 'type')->label(FALSE)->hiddenInput(["value" => "GA"]) ?>
            <div class="text-right">

            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
            ?>
            <?= Html::a('Cancel', ['guarantor-view'], ['class' => 'btn btn-warning']) ?>
<?php
ActiveForm::end();
///print_r($model->errors);
?>

            </div>
        </div>
