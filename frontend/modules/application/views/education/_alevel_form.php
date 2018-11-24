<script>
    function setType(type) {
        $('#create-button-id').attr('style', 'display:none');
        $('#education-under_sponsorship').val('4').change();
         
        //education-are_you_post_f4
              $('#education-registration_number').val('');
              $('#education-completion_year').val('').change();
              $('#education-under_sponsorship').val('').change();
             
        if (type == 'NECTA') {
            //Show
             $('#w2').attr('style', 'display: block');
            $('#avn_id').attr('style', 'display:none');
             $("#education-registration_number").attr('maxlength','10');
             $('.field-education-registration_number').attr('style', 'display:block');
            //Hide
            $('#w1').attr('style', 'display: none');
          //  $('#w3').attr('style', 'display: none');
            $('.field-education-under_sponsorship').attr('style', 'display: none');
            $('#switch_right').val('1');
            $('.field-education-certificate_document').attr('style', 'display:none');
        }
      else if (type == 'NONE-NECTA') {
            //Show
            $('#switch_right').val('2');
             $("#education-registration_number").attr('maxlength','16');
            $('#create-button-id').attr('style', 'display:block');
            $('.field-education-country_id').attr('style', 'display:block');
            $('.field-education-registration_number').attr('style', 'display:block');
            $('.field-education-certificate_document').attr('style', 'display: block');
            $('#avn_id').attr('style', 'display:none');
            $('#w1').attr('style', 'display: block');
            //$('#w3').attr('style', 'display: block');
            $('.field-education-under_sponsorship').attr('style', 'display:block');
            $('#w2').attr('style', 'display: block');
            
            //Hide


        }
     else if (type == 'COLLEGE') {
            $('#switch_right').val('3');
             $("#education-registration_number").attr('maxlength','16');
             $('.field-education-country_id').attr('style', 'display:none');
             $('.field-education-registration_number').attr('style', 'display:none');
             $('#create-button-id').attr('style', 'display:block');
             $('.field-education-certificate_document').attr('style', 'display: block');
            /// ,#document.getElementById('lbltipAddedComment').innerHTML = 'your tip has been submitted!';
            $('#avn_id').attr('style', 'display: block');
            $('#w1').attr('style', 'display: block');
            $('#w2').attr('style', 'display: block');
           // $('#w3').attr('style', 'display: block');
            $('.field-education-under_sponsorship').attr('style', 'display:block');
        }
    }
    function check_sponsorship() {
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
        // alert(status);
         document.getElementById("w3").style.display = "block";
        if (status == 1) {
            $('#create-button-id').attr('style', 'display: none');
            $('.field-education-sponsor_proof_document').attr('style', 'display:none');
          
           // document.getElementById("w4").style.display = "none";
           // document.getElementById("w5").style.display = "none";
            
        }
        //document.getElementById("w5").style.display = "none";

        if (registrationId != "" && year != "" && status == 1) {
            document.getElementById("loader").style.display = "block";
            document.getElementById("myDiv").style.display = "none";
            //document.getElementById("w4").style.display = "none";


            $.ajax({
                type: 'post',
                //dataType: 'json',
                url: "<?= Yii::$app->getUrlManager()->createUrl('/application/default/necta-alevel'); ?>",
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
            $('#create-button-id').attr('style', 'display: block');
             $('.field-education-under_sponsorship').attr('style', 'display: block');
            //document.getElementById("w3").style.display = "block";
            document.getElementById("w4").style.display = "block";
            document.getElementById("w5").style.display = "block";
            document.getElementById("w6").style.display = "block";

        } else {
            $('#create-button-id').attr('style', 'display: none');
          // document.getElementById("w3").style.display = "block";
            $('.field-education-under_sponsorship').attr('style', 'display: none');
            document.getElementById("w4").style.display = "none";
            document.getElementById("w5").style.display = "none";
            document.getElementById("w6").style.display = "none";

        }
    }
      function check_postform4() {
        var status = document.getElementById('education-are_you_post_f4').value;
        if (status == 1) {
            $('#hide_all').attr('style', 'display:block');
            $('#create-button-id').attr('style', 'display:none');
            $('#education-registration_number').val('');
            $('#education-completion_year').val('').change(); 
               $('#switch_right').val('1');
        }
        else {
            $('#hide_all').attr('style', 'display:none');
          
            $('#education-registration_number').val('S0750.0023');
            $('#education-completion_year').val('2006').change();
              $('#education-under_sponsorship').val('2').change();
             $('#switch_right').val('4');
             $('#create-button-id').attr('style', 'display: block');
            
        }
    }
</script>
<?php
$yearmax = date("Y");
for ($y = 1950; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
//print_r($model->errors);
?>
<style>
   #hide_all, #myDiv,#create-button-id,#avn_id,#w1,#w2,.field-education-certificate_document,.field-education-under_sponsorship{
        display: none;
        //text-align: center;
    }
</style>
<div class="education-form">

    <?php
    $necta = '';
    $nonenecta = '';
    $college = '';
     if ($model->are_you_post_f4 == 1 && $model->are_you_post_f4 != NULL) {
        
        echo '<style>
        #hide_all{
            display:block;
        }
    </style>';
    }  else {
        //   $model->are_you_post_f4 =6;
             $model->is_necta=4;
             $model->registration_number='S0750.0023';
             $model->under_sponsorship=2;
             $model->completion_year=2007;
               echo '<style>
       
        #create-button-id{
            display:block;
        } 
    </style>';
     }
   
    if ($model->is_necta == 1 && $model->is_necta != NULL) {
        $necta = "checked='checked'";
        echo '<style>
        #w1, .field-education-certificate_document{
            display: none;
        }
        #create-button-id,#w2,#w3{
            display:block;
        } 
    </style>';
    } else if ($model->is_necta == 2 && $model->is_necta != NULL) {
        $nonenecta = "checked='checked'";
        echo '<style>
        #w2{
            display: none;
        }
         #create-button-id,#w2,#w1,.field-education-certificate_document{
            display:block;
        } 
    </style>';
    } else if ($model->is_necta ==3 && $model->is_necta != NULL) {
        $college = "checked='checked'";
        
        echo '<style>
      
        #create-button-id,#avn_id,#w1,#w2,#w3 ,.field-education-certificate_document{
            display:block;
        } 
       .field-education-country_id,.field-education-registration_number{
            display: none;
        }
    </style>';
    }
    if ($model->under_sponsorship == 1 && $model->under_sponsorship != NULL&&$model->is_necta !=4 ) {
        //$nonenecta = "checked='checked'";
        echo '<style>
        .field-education-sponsor_proof_document,.field-education-under_sponsorship{
            display:block;
        }
         .field-education-under_sponsorship{
            display:none;
        }
    </style>';
    } else   if ($model->under_sponsorship == 2 && $model->under_sponsorship != NULL&&$model->is_necta !=4 ) { 
         echo '<style>
      .field-education-sponsor_proof_document {
            display: none;
        }
       .field-education-under_sponsorship{
            display:block;
        }
    </style>';    
    }
      else {
        echo '<style>
      .field-education-sponsor_proof_document {
            display: none;
        }
       .field-education-under_sponsorship{
            display:none;
        }
    </style>';
    }
    if ($model->isNewRecord == 1) {
        echo '<style>
       #create-button-id{
            display:none;
        }
    </style>';
    }
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                'options' => ['enctype' => 'multipart/form-data'],
                'enableClientValidation' => TRUE,
    ]);
    //  echo "miki".$model->isNewRecord;
       if($modelApplication->applicant_category_id==3){
     ?>
       <?= $form->field($model, 'are_you_post_f4')->dropDownList(
                                [1 => "YES", 2 => "NO"], 
                                [
                                'prompt'=>'[--Select Status--]',
                                'onchange' => 'check_postform4()',
                                ]
                    );
       }
       else{
         echo '<style>
        #hide_all{
            display:block;
        }
    </style>';     
       }
     ?> 
   <div id="hide_all">
   <center>  
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('NECTA')" value="1" <?php echo $necta; ?> >NECTA [Completed in Tanzania]</label>
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('NONE-NECTA')" value="2" <?php echo $nonenecta; ?> >NON-NECTA [Holders of Foreign Certificates]</label>
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('COLLEGE')" value="3" <?php echo $college; ?> >Equivalent Qualification (e.g. Diploma)</label>
    </center>
    
    <br>
    <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['id' =>'switch_right']) ?>

<?php
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'institution_name' => ['label' => 'Institution Name (*) ', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 50]],
        'country_id' => ['label' => 'Country', 'type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'), 'options' => ['prompt' => '--COUNTRY OF STUDY--']],
    ]
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
     'id'=>'avn_id',
    'attributes' => [
        'programme_name' => ['label' => 'Programme Name (*) ', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 50]],
         'avn_number' => ['label' => 'Award Verification Number (AVN)(*) ', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '', 'maxlength' => 50]],
        //'country_id' => ['label' => 'Country', 'type' => Form::INPUT_DROPDOWN_LIST, 'items' => yii\helpers\ArrayHelper::map(\frontend\modules\application\models\Country::find()->all(), 'country_id', 'country_name'), 'options' => ['prompt' => '--COUNTRY OF STUDY--']],
    ]
]);
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' =>1,
    'attributes' => [
        'registration_number' => ['type' => Form::INPUT_TEXT, 'label' => 'F6 Index #  (*)',
            'options' => ['placeholder' => '', 'onchange' => 'check_necta()', 'data-toggle' => 'tooltip',
                'data-placement' => 'top', 'title' => '']],
        //'registration_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Eg S0112/5887']],
        'completion_year' => ['type' => Form::INPUT_WIDGET,
            'widgetClass' => \kartik\select2\Select2::className(),
            'label' => 'Completion Year (*)',
            'options' => [
                'data' => $year,
                'options' => [
                    'prompt' => 'Select Completion Year ',
                    'onchange' => 'check_necta()'
                //'id'=>'entry_year_id'
                ],
            ],
        ],
    ]
]);
echo "<center><div id='loader' style='display:none'>  <p><img src='image/loader/loader1.gif' /> Please Wait</p></div></center><div style='display:none;' id='myDiv' class='animate-bottom'></div>";
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
    'options' => ['accept' => 'image/*'],
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
        'initialCaption' => sponsor_proof_document,
        'initialPreviewAsData' => true,
         'initialPreviewConfig' => [
            ['type'=> explode(".",$model->sponsor_proof_document)[1]=="pdf"?"pdf":"image"],
        ],
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
            ['type'=> explode(".",$model->certificate_document)[1]=="pdf"?"pdf":"image"],
        ],
        'initialCaption'=>$model->certificate_document,
        'initialPreviewAsData'=>true,
         
    ]
]);
?>
   </div>
    <div class="text-right"  id='create-button-id' style="">

    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>

    <?php
    echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
    ?>
    <?= Html::a('Cancel', ['alevel-view'], ['class' => 'btn btn-warning']) ?>
    <?php
    ActiveForm::end();
   // print_r($model->errors);
    ?>
    </div>
</div>
    