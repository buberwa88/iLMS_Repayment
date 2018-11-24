  <script>
    function check_sponsorship() {//
        var status = document.getElementById('education-under_sponsorship').value;
        if (status == 1) {
            $('.field-education-sponsor_proof_document').attr('style', 'display:block');
            // $('#form_data_id').attr('style', 'display:block'); 
        }
        else {
          $('.field-education-sponsor_proof_document').attr('style', 'display:none');
        }
    }
     function check_country() {//
        var status = document.getElementById('education-country_id').value;
           ///alert(status);
        if (status == 1) {
         $('.field-education-region_id').attr('style', 'display:block');
       
        }
        else {
          $('.field-education-region_id').attr('style', 'display:none');
        }
    }
    </script>
   <style>
    .field-education-region_id,.field-education-sponsor_proof_document{
        display: none;
        //text-align: center;
    }
</style> 
<?php
$yearmax = date("Y");
for ($y = 1950; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
   if ($model->country_id==1) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        .field-education-region_id{
            display:block;
        }
    </style>';
        } else {
    echo '<style>
      .field-education-region_id{
            display: none;
        }
    </style>';
      }
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;

?>
 
<div class="education-form">

    <?php
    
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,
    ]);
    //  echo "miki".$model->isNewRecord;
                    if($modelApplication->applicant_category_id==5){
                     $level=['BACHELOR'=>'Bachelor','MASTERS'=>"Masters"];  
                     echo "<h3 class='label label-warning'>To complete this level, please provide both your Bachelor and Masters education information</h3>";
                    }
                    else{
                      $level=['BACHELOR'=>'Bachelor'];  
                    }
                   // echo $modelApplication->applicant_category_id;
    ?>

    
    <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['id' =>'switch_right','value'=>5]) ?>

<?php
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'level' => ['label' => 'Level Of Study', 'type' => Form::INPUT_DROPDOWN_LIST, 'items' =>$level, 'options' => ['prompt' => '--Study Level--']],
        'institution_name' => ['label' => 'Institution Name (*) ', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 50]],
           //'country_id' => ['label' => 'Country', 'type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'), 'options' => ['prompt' => '--COUNTRY OF STUDY--']],
            'country_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Country Name',
                       
                'options' => [
                    'data' =>yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'),
                    'options' => [
                        'prompt' => 'Select Country Name',
                        'onchange' => 'check_country()',
                       // 'id'=>'region_Id'
                    ],
                ],
            ],
        //'region_id' => ['label' => 'Region', 'type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'), 'options' => ['prompt' => '--COUNTRY OF STUDY--']],   
               'region_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Region',
                       
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                    'options' => [
                        'prompt' => 'Select Region Name',
                       //  'onchange' => 'check_reset()',
                       // 'id'=>'region_Id'
                    ],
                ],
            ],
        ]
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
     'id'=>'avn_id',
    'attributes' => [
        'programme_name' => ['label' => 'Programme Name (*) ', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 50]],
        'avn_number' => ['label' => 'Registration Number (*) ', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 50]],
        //'country_id' => ['label' => 'Country', 'type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'), 'options' => ['prompt' => '--COUNTRY OF STUDY--']],
    ]
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' =>2,
    'attributes' => [
        
        //'registration_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg S0112/5887']],
        'entry_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Entry Year (*)',
            'options' => [
                'data' => $year,
                'options' => [
                    'prompt' => 'Select Entry Year ',
                    //'onchange' => 'check_necta()'
                //'id'=>'entry_year_id'
                ],
            ],
        ],
    'completion_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Completion Year (*)',
            'options' => [
                'data' => $year,
                'options' => [
                    'prompt' => 'Select Completion Year ',
                   // 'onchange' => 'check_necta()'
                //'id'=>'entry_year_id'
                ],
            ],
        ],
    ]
]);

//echo "<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center><div style='display:none;' id='myDiv' class='animate-bottom'></div>";
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' =>1,
    'attributes' => [
        'under_sponsorship' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Were you sponsored ?  (*)',
            'options' => [
                'data' => [1 => "YES", 2 => "NO"],
                'options' => [
                    'prompt' => 'Select',
                    'onchange' => 'check_sponsorship()',
                // 'id'=>'sponsered_id'
                ],
            ],
        ],
    //'completion_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg. 2001']],
    ]
]);
echo $form->field($model, 'sponsor_proof_document')->widget(FileInput::classname(), [
    'options' => ['accept' => 'application/pdf'],
    'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => true,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' => 'Attach Sponsorship Proof Document (required format .pdf,.jpg and .png only)',
        'initialPreview' => [
            "$model->sponsor_proof_document",
        ],
        'initialCaption' => $model->sponsor_proof_document,
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => [
            ['type'=> explode(".",$model->sponsor_proof_document)[1]=="pdf"?"pdf":"image"],
        ],
    ]
]);
echo $form->field($model, 'certificate_document')->widget(FileInput::classname(), [
       'options' => ['accept' => 'application/pdf'],
        'pluginOptions' => [
         'initialPreviewShowDelete' => true,
         'showCaption' => false,
        //'showRemove' => TRUE,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach Academic Certificate Document (required format .pdf,.jpg and .png only)',
             'initialPreview'=>[
            "$model->certificate_document",
           
        ],
        'initialPreviewConfig' => [
            ['type'=> explode(".",$model->certificate_document)[1]=="pdf"?"pdf":"image"],
        ],
        'initialCaption'=>$model->certificate_document,
        'initialPreviewAsData'=>true,
         
    ]
]);
?>
    <div class="text-right"  id='create-button-id' style="">

    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['tlevel-view'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
   // print_r($model->errors);
    ?>
    </div>
</div>