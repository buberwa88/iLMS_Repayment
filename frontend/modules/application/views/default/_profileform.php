<script>
    function check_disability() {
   var status = document.getElementById('applicant-disability_status').value;
        
          if(status=="YES"){
             // alert(status);
          $('.field-applicant-disability_document').attr('style', 'display: block');    
          }
          else{
           $('.field-applicant-disability_document').attr('style', 'display:none');       
          }
    }
    function check_tasaf() {
   var status = document.getElementById('applicant-tasaf_support').value;
        
          if(status=="YES"){
             // alert(status);
          $('.field-applicant-tasaf_support_document').attr('style', 'display: block');    
          }
          else{
           $('.field-applicant-tasaf_support_document').attr('style', 'display:none');       
          }
    }
  </script>
 <style>
  .field-applicant-disability_document{
        display: none;
    }
</style> 
<?php
//
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model frontend\modules\application\models\User */
/* @var $form yii\widgets\ActiveForm */
   if ($modelall->disability_status=="YES" && $modelall->disability_status != NULL) {
       //$nonenecta = "checked='checked'";
        echo '<style>
        .field-applicant-disability_document{
            display:block;
        }
    </style>';
    } else {
        echo '<style>
      .field-applicant-disability_document{
            display: none;
        }
    </style>';
    }
    if ($modelall->tasaf_support=="YES" && $modelall->tasaf_support != NULL) {
       //$nonenecta = "checked='checked'";
        echo '<style>
        .field-applicant-tasaf_support_document{
            display:block;
        }
    </style>';
    } else {
        echo '<style>
       .field-applicant-tasaf_support_document{
            display: none;
        }
    </style>';
    }
                   if($modelapp->applicant_category_id==2||$modelapp->applicant_category_id==5||$modelapp->applicant_category_id==4||$modelapp->applicant_category_id==3){
                    $tasaf_label=['NONE' => 'NONE'];   
                    $modelall->tasaf_support='NONE';
                     echo '<style>
                            .field-applicant-tasaf_support, .field-applicant-tasaf_support_document{
                                  display: none;
                              }
                          </style>';
                 
                   }
                   else{
                   $tasaf_label=['YES' => 'YES', 'NO' => 'NO'];      
                   }
            
?>

<div class="user-form">
        <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                 
                 'options' => ['enctype' => 'multipart/form-data','id'=>'myformId'],
                'enableClientValidation' => TRUE,
    ]);
//        echo Form::widget([
//            'model' => $model,
//            'form' => $form,
//            'columns' => 2,
//            'id' => "mickidadi12",
//            'attributes' => [
//                'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
//                'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
//            ]
//        ]);
//        echo Form::widget([
//            'model' => $model,
//            'form' => $form,
//            'columns' => 2,
//            'id' => "mickidadi21",
//            'attributes' => [
//                'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter ']],
//                
//                'sex' => [
//                    'type' => Form::INPUT_DROPDOWN_LIST,
//                    'items' => ['M' => 'Male', 'F' => 'Female'],
//                    'prompt' => 'Select Gender',
//                ],
//            ]
//        ]);
     echo $form->field($modelapp, 'passport_photo')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
         'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'overwriteInitial'=>false,
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-camera"></i> ',
        'browseLabel' =>  'Attach Passport Photo (Width=150px,height=160px required formate .jpg and .png only)',
          'initialPreview'=>[
            $modelapp->passport_photo==""?"image/no_photo2.png":$modelapp->passport_photo,
           
        ],
        'initialCaption'=>$modelapp->passport_photo==""?"image/no_photo1.png":$modelapp->passport_photo,
        'initialPreviewAsData'=>true,
        
    ]
]);
         echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'columns' =>2,
            'attributes' => [
                'date_of_birth' => ['type'=> Form::INPUT_WIDGET, 'widgetClass'=>\kartik\widgets\DatePicker::classname(), 'options' => [ 'pluginOptions' => ['format' => 'yyyy-mm-dd','todayHighlight' => true, 'autoclose'=>true,],]],
                'birth_certificate_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
                
            
         ]
        ]);
 
  echo $form->field($modelall, 'birth_certificate_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
         'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'overwriteInitial'=>false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Birth Certificate Document (required format .pdf,.jpg and .png only)',
          'initialPreview'=>[
            "$modelall->birth_certificate_document",
           
        ],
     'initialPreviewConfig' => [
            ['type'=> explode(".",$modelall->birth_certificate_document)[1]=="pdf"?"pdf":"image"],
        ],
        'initialCaption'=>$modelall->birth_certificate_document,
        'initialPreviewAsData'=>true,
    ]
]);
   if(!$model->isNewRecord&&$modelall->place_of_birth>0){
       $modelz=  \backend\modules\disbursement\models\Ward::findOne($modelall->place_of_birth);
         
       $modelall->district_id=$modelz->district_id;
       ################find region Id ##############
       
        $modelr= \common\models\District::findOne($modelz->district_id);
        $modelall->region_id=$modelr->region_id;
         }
       echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                ///'physical_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg Plot No. 8, Block No. 46 Ubungo, Dar es Salaam']],
               // 'mailing_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg P. O Box 76068 Dar es Salaam']],
                'region_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Birth Region',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                    'options' => [
                        'prompt' => 'Select Birth Region ',
                        //'id'=>'region_Id'
                    ],
                ],
            ],
    'district_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Birth District',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(\common\models\District::find()->where(['region_id'=>$modelall->region_id])->all(), 'district_id', 'district_name'),
                      'options' => [
                        'prompt' => 'Select Birth District ',
                       // 'id'=>'district_id'
                    ],
                    'pluginOptions' => [
                        'depends' => ['applicant-region_id'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/application/district/district-name']),
                    ],
                ],
            ],
  'place_of_birth' => ['type' => Form::INPUT_WIDGET,
               // 'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Birth Ward',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(backend\modules\application\models\Ward::find()->where(['district_id'=>$modelall->district_id])->all(), 'ward_id', 'ward_name'),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['applicant-district_id'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/application/district/ward-name']),
                    ],
                ],
            ],
          'identification_type_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Identification Type (Non-mandatory) ',
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

     echo $form->field($modelall, 'identification_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => true,
        //['previewFileType' => 'pdf'],
        'showUpload' => false,
//          'fileActionSettings' => [
//            'showZoom' => false,
//            ],
       // 'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Identification Document (required format .pdf,.jpg and .png only)',
         'initialPreview'=>[
            "$modelall->identification_document",
           
        ],
       'initialPreviewConfig' => [
            ['type'=>explode(".",$modelall->identification_document)[1]=="pdf"?"pdf":"image"],
        ],
        'initialCaption'=>$modelall->identification_document,
        'initialPreviewAsData'=>true,
    ]
]);

        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => '075*******']],
                'email_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Your Email ']],
            ]
        ]);
       echo Form::widget([
            'model' => $modelapp,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'bank_account_name' => ['label'=>'Bank Account Name (Non-mandatory)','type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
                'bank_account_number' => ['label'=>'Bank Account Number(Non-mandatory)','type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
            ]
                    ]);
         if(!$model->isNewRecord&&$modelall->place_of_domicile>0){
       $modelz1=  \backend\modules\disbursement\models\Ward::findOne($modelall->place_of_domicile);
         
       $modelall->district_id_domicile=$modelz1->district_id;
       ################find region Id ##############
       
        $modelr1= \common\models\District::findOne($modelz1->district_id);
        $modelall->region_id_domicile=$modelr1->region_id;
         }
       echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'physical_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg Plot No. 8, Block No. 46 Ubungo, Dar es Salaam']],
                'mailing_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg P. O Box 76068 Dar es Salaam']],
                'region_id_domicile' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Region',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                    'options' => [
                        'prompt' => 'Select Region ',
                        //'id'=>'region_Id'
                    ],
                ],
            ],
     'district_id_domicile' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(\common\models\District::find()->where(['region_id'=>$modelall->region_id_domicile])->all(), 'district_id', 'district_name'),
                      'options' => [
                        'prompt' => 'Select District ',
                       // 'id'=>'district_id'
                    ],
                    'pluginOptions' => [
                        'depends' => ['applicant-region_id_domicile'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/application/district/district-name']),
                    ],
                ],
            ],
  'place_of_domicile' => ['type' => Form::INPUT_WIDGET,
               // 'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Ward',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(backend\modules\application\models\Ward::find()->where(['district_id'=>$modelall->district_id_domicile])->all(), 'ward_id', 'ward_name'),
                    //'disabled' => $model->isNewrecord ? false : true,
                    'pluginOptions' => [
                        'depends' => ['applicant-district_id_domicile'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/application/district/ward-name']),
                    ],
                ],
            ],
    'village_domicile' => ['label'=>'Village/Street','type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
            ]
        ]);
  echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'disability_status'=>[
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' => ['YES' => 'YES', 'NO' => 'NO'],
                    'options' => [
                          'prompt' => 'Select Disability Status',
                          'onchange' => 'check_disability()',
                    ],
                  
                ],
            ]
      
        ]);
echo $form->field($modelall, 'disability_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
        'fileActionSettings' => [
            'showZoom' => false,
            ],
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Disability Document (required format .pdf,.jpg and .png only)',
       'initialPreview'=>[
            "$modelall->disability_document",
           
        ],
       'initialPreviewConfig' => [
            ['type'=>explode(".",$modelall->disability_document)[1]=="pdf"?"pdf":"image"],
        ],
        'initialCaption'=>$modelall->disability_document,
        'initialPreviewAsData'=>true,
    ]
]);
  echo Form::widget([
            'model' => $modelall,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'tasaf_support'=>[
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' => $tasaf_label,
                    'options' => [
                          'prompt' => 'Select  TASAF Status',
                          'onchange' => 'check_tasaf()',
                    ],
                  
                ],
            ]
      
        ]);
echo $form->field($modelall, 'tasaf_support_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
        'fileActionSettings' => [
            'showZoom' => false,
            ],
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach TASAF Proof  Document (required format .pdf,.jpg and .png only)',
       'initialPreview'=>[
            "$modelall->tasaf_support_document",
           
        ],
       'initialPreviewConfig' => [
            ['type'=>explode(".",$modelall->tasaf_support_document)[1]],
        ],
        'initialCaption'=>$modelall->tasaf_support_document,
        'initialPreviewAsData'=>true,
    ]
]);
        ?>
  <div class="text-right">
   <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
 <?php echo Html::Button('Reset', ['class' => 'btn btn-default','id'=>'reset-form','onclick' => '(function ( $event ) {  $("#myformId")[0].reset(); })();$("select").val("").trigger("change");   $(this).closest("form").find("input[type=text], textarea").val("");']);
            ?>
 <?= Html::a('Cancel', ['my-profile'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
    </div>

