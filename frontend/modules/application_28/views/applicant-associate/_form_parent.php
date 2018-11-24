 <script>
    function check_alive() {//
   var status = document.getElementById('applicantassociate-is_parent_alive').value;
          if(status=="YES"){
              //document.getElementById("parent_form").reset();
          $('.field-applicantassociate-death_certificate_number').attr('style', 'display: none'); 
           $('.field-applicantassociate-death_certificate_document').attr('style', 'display:none'); 
           $('.field-applicantassociate-disability_status').attr('style', 'display:block'); 
              $('#form_data_id').attr('style', 'display:block'); 
          }
          else{
          // document.getElementById("parent_form").reset();
             $('#applicantassociate-disability_status').val('');
           $('.field-applicantassociate-death_certificate_number').attr('style', 'display:block');   
           $('.field-applicantassociate-death_certificate_document').attr('style', 'display:block');  
            $('.field-applicantassociate-disability_status').attr('style', 'display:none'); 
              $('.field-applicantassociate-disability_document').attr('style', 'display:none');
            $('#form_data_id').attr('style', 'display:none'); 
          }
    }
      function check_disability() {
   var status = document.getElementById('applicantassociate-disability_status').value;
          if(status=="YES"){
          $('.field-applicantassociate-disability_document').attr('style', 'display: block');    
          }
          else{
           $('.field-applicantassociate-disability_document').attr('style', 'display:none');       
          }
    }
  </script>
 <style>
    #form_data_id,.field-applicantassociate-disability_status,.field-applicantassociate-disability_document ,.field-applicantassociate-death_certificate_document ,.field-applicantassociate-death_certificate_number {
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
$yearmax = date("Y");
for ($y = 1988; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
 if ($model->disability_status=="YES" && $model->disability_status != NULL&&$model->is_parent_alive=="YES") {
       //$nonenecta = "checked='checked'";
        echo '<style>
        .field-applicantassociate-disability_status , .field-applicantassociate-disability_document{
            display:block;
        }
    </style>';
    }
   else if ($model->disability_status=="NO" && $model->disability_status != NULL&&$model->is_parent_alive=="YES") {
       //$nonenecta = "checked='checked'";
        echo '<style>
        .field-applicantassociate-disability_status{
            display:block;
        }
    </style>';
    } else {
        echo '<style>
      .field-applicantassociate-disability_status_document{
            display: none;
        }
    </style>';
    }
    if ($model->is_parent_alive=="NO" && $model->is_parent_alive != NULL) {
       //$nonenecta = "checked='checked'";
        echo '<style>
        .field-applicantassociate-death_certificate_document{
            display:block;
        }
    </style>';
    }
  if ($model->is_parent_alive=="YES" && $model->is_parent_alive != NULL||$model->is_parent_alive=="YES" && $model->is_parent_alive != NULL&&count($modelall->errors)>0) {
       //$nonenecta = "checked='checked'";
        echo '<style>
         #form_data_id{
            display:block;
        }
    </style>';
    } 
    else {
        echo '<style>
      #form_data_id{
            display: none;
        }
    </style>';
    }
    
    
?>

<div class="education-form">
   <?php
        $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                 'options' => ['enctype' => 'multipart/form-data','id'=>'parent_form'],
                 
                 'enableClientValidation' => TRUE,
    ]);
    ?>
    <?php
       if(!$model->isNewRecord&&$model->ward_id>0){
       $modelz=  \backend\modules\disbursement\models\Ward::findOne($model->ward_id);
         
       $model->district_id=$modelz->district_id;
       ################find region Id ##############
       
        $modelr= \common\models\District::findOne($modelz->district_id);
        $model->region_id=$modelr->region_id;
         }
       echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
           
            'attributes' => [
                    'is_parent_alive'=>[
                    'type' => Form::INPUT_DROPDOWN_LIST,
                     'label'=>"Is your $position alive ?",
                    'items' => ['YES' => 'YES', 'NO' => 'NO'],
                    'options' => [
                          'prompt' => 'Select  Status',
                          'onchange' => 'check_alive()',
                    ],
                   ]
            ]
        ]);
       echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
               'death_certificate_number' => ['type' => Form::INPUT_TEXT, 'label' => 'Death Certificate Number', 'options' => ['placeholder' => 'Enter ']],
            ]
        ]);
    echo $form->field($model, 'death_certificate_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
        'showCaption' => false,
        'showRemove' =>true,
        'showUpload' => false,
          'initialPreview'=>[
            "$model->death_certificate_document",
           
        ],
        'initialCaption'=>$model->death_certificate_document,
        'initialPreviewAsData'=>true,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Death Certificate Document'
    ]
]);
   echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
           
            'attributes' => [
                    'disability_status'=>[
                     'label'=>"Is your $position Disabled ?",
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' => ['YES' => 'YES', 'NO' => 'NO'],
                    'options' => [
                          'prompt' => 'Select Disability Status',
                          'onchange' => 'check_disability()',
                    ],
                    ]
            ]
        ]);
 echo $form->field($model, 'disability_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        'initialPreview'=>[
            "$model->disability_document",
           
        ],
        'initialCaption'=>$model->disability_document,
        'initialPreviewAsData'=>true,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Disability Document'
    ]
]);
   echo "<div id='form_data_id'>";
    echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'id' => "mickidadi12",
            'attributes' => [
       
                'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
                'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
                'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Surname', 'options' => ['placeholder' => 'Enter ']],
//                'sex' => [
//                    'type' => Form::INPUT_DROPDOWN_LIST,
//                    'items' => ['M' => 'Male', 'F' => 'Female'],
//                    'prompt' => 'Select Gender',
//                ],
                    'occupation_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Occupation',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Occupation::find()->all(), 'occupation_id', 'occupation_desc'),
                    'options' => [
                        'prompt' => 'Select Occupation',
                        
                    ],
                ],
            ],
                'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => '0**********']],
                'postal_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
                'physical_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
                'email_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => ' ']],
               // 'NID' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '']],
              //  'email_address' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Your Email ']],
                'region_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Region',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                    'options' => [
                        'prompt' => 'Select Region Name',
                        'id'=>'region_Id'
                    ],
                ],
            ],
    'district_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(\common\models\District::find()->where(['region_id'=>$model->region_id])->all(), 'district_id', 'district_name'),
                     'options' => [
                        'prompt' => 'Select District Name',
                        'id'=>'district_id'
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
                    'data' =>  ArrayHelper::map(backend\modules\application\models\Ward::find()->where(['district_id'=>$model->district_id])->all(), 'ward_id', 'ward_name'),
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
    echo "</div>";  
        ?>
    <?= $form->field($model, 'type')->label(FALSE)->hiddenInput(["value"=>"PR"]) ?>
    <?= $form->field($model, 'sex')->label(FALSE)->hiddenInput(["value"=>$model->isNewRecord?$sex:$model->sex]) ?>
    <div class="text-right">
        
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
        <?= Html::a('Cancel', ['parent-view'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();

?>
 
    </div>
</div>