<script>
      document.getElementById("loader").style.display = "none";
    function setType(type) {
       
        if (type == 'NECTA') {
            //Show
             $('#switch_right').val('1');
              $("#education-registration_number").attr('maxlength','10');
               $('.field-education-certificate_document').attr('style', 'display:none');
            $('#w2').attr('style', 'display: block');
            //Hide
            $('#w1').attr('style', 'display: none');
            //$('#w3').attr('style', 'display: none');
            $('#create-button-id').attr('style', 'display:none'); 
            $('.field-education-under_sponsorship').attr('style', 'display:none');
            document.getElementById("myDiv").style.display = "none";
        }
       if (type == 'NONE-NECTA') {
            //Show
            $("#education-registration_number").attr('maxlength','16');
            $('#switch_right').val('2');
            $('#w1').attr('style', 'display: block');
            $('#w3').attr('style', 'display: block');
            $('#w2').attr('style', 'display: block');
             document.getElementById("myDiv").style.display = "none";
            $('.field-education-certificate_document').attr('style', 'display: block');
            //Hide  
            $('#create-button-id').attr('style', 'display: block'); 
            $('.field-education-under_sponsorship').attr('style', 'display: block');     
        }
    }
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
    function check_necta() {
        var registrationId = document.getElementById('education-registration_number').value;
        var year = document.getElementById('education-completion_year').value;
        var status = document.getElementById('switch_right').value;
        //var status="Halima"; 
             if(status == 1){
          $('#create-button-id').attr('style', 'display: none');
           
             }
     
        if (registrationId != "" && year != "" && status == 1) {
            document.getElementById("loader").style.display = "block";
            document.getElementById("myDiv").style.display = "none";
            
            $.ajax({
                type: 'post',
                //dataType: 'json',
                url: "<?= Yii::$app->getUrlManager()->createUrl('/application/default/nectain'); ?>",
                data: {registrationId: registrationId, year: year},
                success: function (data) {
                    document.getElementById("loader").style.display = "none";
                    document.getElementById("myDiv").style.display = "block";
                    $('#myDiv').html(data);
                }
            });
        }
        return false;
    }
    function check_status() {
        // $('#checkboxId').is(':checked')
        if ($('#user-validated').is(':checked')) {
            //form-group field-user-verifycode
            $('#create-button-id').attr('style', 'display: block');
             $('.field-education-under_sponsorship').attr('style', 'display:block');
         

        } else {
            $('#create-button-id').attr('style', 'display: none');
           $('.field-education-under_sponsorship').attr('style', 'display:none');
            

        }
    }

</script>
 
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
?>

<div class="education-form">

    <?php
    $necta = '';
    $nonenecta = '';
    if ($model->is_necta == 1 && $model->is_necta != NULL) {
        $necta = "checked='checked'";
        echo '<style>
        #w1, .field-education-certificate_document{
            display: none;
        }
    </style>';
    } else if ($model->is_necta == 2 && $model->is_necta != NULL) {
        $nonenecta = "checked='checked'";
//        echo '<style>
//        #w2{
//            display: none;
//        }
//    </style>';
    } else {

        echo '<style>
        #w1, #w2, #create-button-id,.field-education-certificate_document{
            display: none;
        }
    </style>';
    }
    
   if ($model->under_sponsorship==1 && $model->under_sponsorship != NULL) {
    //$nonenecta = "checked='checked'";
    echo '<style>
        .field-education-sponsor_proof_document{
            display:block;
        }
    </style>';
} else {
    echo '<style>
      .field-education-sponsor_proof_document{
            display: none;
        }
    </style>';
}  
     $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                 
                 'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,
    ]);
    $yearmax = date("Y");
for ($y = 1988; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
    ?>
 
       <center>  
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('NECTA')" value="1" <?php echo $necta; ?> >NECTA [Completed in Tanzania]</label>
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('NONE-NECTA')" value="2" <?php echo $nonenecta; ?> >NON-NECTA [Holder of Foreign Certificate]</label>
       
    </center>
    
    <br>
    <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['id' =>'switch_right']) ?>

    <?php
    
     echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
              'institution_name' => ['label'=>'O-Level School Name', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Olevel School Name', 'maxlength' => 50]],
              'country_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'),   'options' => ['prompt' => '--COUNTRY OF STUDY--']],
        ]
    ]);
    
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
              'registration_number' => ['type' => Form::INPUT_TEXT, 'label' => 'F4 Index #  (*)',
            'options' => ['placeholder' => '','maxlength'=>10, 'onchange' => 'check_necta()', 'data-toggle' => 'tooltip',
                'data-placement' => 'top', 'title' => '']],
               'completion_year' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Completion Year (*)',
                'options' => [
                    'data' => $year,
                    'options' => [
                        'prompt' => 'Select Completion Year',
                        //'id'=>'entry_year_id'
                        'onchange' => 'check_necta()'
                    
                    ],
                ],   
            ],
            'under_sponsorship' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Were you sponsored ? (*)',
                'options' => [
                    'data' =>[1=>"YES",2=>"NO"],
                    'options' => [
                        'prompt' => 'Select',
                        'onchange' => 'check_sponsorship()',
                        //'id'=>'entry_year_id'
                    
                    ],
                ],
            ],
            //'completion_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg. 2001']],
               
            ]
        
    ]);
     echo "<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center><div style='display:none;' id='myDiv' class='animate-bottom'></div>";
   echo $form->field($model, 'sponsor_proof_document')->widget(FileInput::classname(), [
        
       'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
         'initialPreviewShowDelete' => true,
         'showCaption' => false,
        //'showRemove' => TRUE,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach sponsorship Proof Document (required format .pdf,.jpg and .png only)',
             'initialPreview'=>[
            "$model->sponsor_proof_document",
           
        ],
       'initialPreviewConfig' => [
            ['type'=>explode(".",$model->sponsor_proof_document)[1]=="pdf"?"pdf":"image"],
        ],
        'initialCaption'=>sponsor_proof_document,
        'initialPreviewAsData'=>true,
         
    ]
]);
echo $form->field($model, 'certificate_document')->widget(FileInput::classname(), [
        
       'options' => ['accept' => 'image/*'],
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
            ['type'=>explode(".",$model->sponsor_proof_document)[1]=="pdf"?"pdf":"image"],
        ],
        'initialCaption'=>$model->certificate_document,
        'initialPreviewAsData'=>true,
         
    ]
]);
?>
    <div class="text-right" id="create-button-id">

            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
            ?>
            <?= Html::a('Cancel', ['olevel-view'], ['class' => 'btn btn-warning']) ?>
            </div>
<?php
ActiveForm::end();
//print_r($model->errors);
?>