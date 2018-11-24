<script>
    function setType(type) {
        $('#create-button-id').attr('style', 'display:none');
        if (type == 'NECTA') {
            //Show
             $('#w2').attr('style', 'display: block');
            $('#avn_id').attr('style', 'display:none');
             $("#education-registration_number").attr('maxlength','10');
             $('.field-education-registration_number').attr('style', 'display:block');
            //Hide
            $('#w1').attr('style', 'display: none');
            $('#w3').attr('style', 'display: none');
            $('#switch_right').val('1');
        }
      else if (type == 'NONE-NECTA') {
            //Show
            $('#switch_right').val('2');
             $("#education-registration_number").attr('maxlength','16');
            $('#create-button-id').attr('style', 'display:block');
            $('.field-education-country_id').attr('style', 'display:block');
             $('.field-education-registration_number').attr('style', 'display:block');
            $('#avn_id').attr('style', 'display:none');
            $('#w1').attr('style', 'display: block');
            $('#w3').attr('style', 'display: block');
            $('#w2').attr('style', 'display: block');
            
            //Hide


        }
     else if (type == 'COLLEGE') {
            $('#switch_right').val('3');
             $("#education-registration_number").attr('maxlength','16');
            $('.field-education-country_id').attr('style', 'display:none');
             $('.field-education-registration_number').attr('style', 'display:none');
             $('#create-button-id').attr('style', 'display:block');
            /// ,#document.getElementById('lbltipAddedComment').innerHTML = 'your tip has been submitted!';
            $('#avn_id').attr('style', 'display: block');
            $('#w1').attr('style', 'display: block');
            $('#w2').attr('style', 'display: block');
            $('#w3').attr('style', 'display: block');
            
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
        if (status == 1) {
            $('#create-button-id').attr('style', 'display: none');
            $('.field-education-sponsor_proof_document').attr('style', 'display:none');
            document.getElementById("w3").style.display = "none";
            document.getElementById("w4").style.display = "none";
            document.getElementById("w5").style.display = "none";
            
        }
        //document.getElementById("w5").style.display = "none";

        if (registrationId != "" && year != "" && status == 1) {
            document.getElementById("loader").style.display = "block";
            document.getElementById("myDiv").style.display = "none";
            document.getElementById("w4").style.display = "none";


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
            document.getElementById("w3").style.display = "block";
            document.getElementById("w4").style.display = "block";
            document.getElementById("w5").style.display = "block";
            document.getElementById("w6").style.display = "block";

        } else {
            $('#create-button-id').attr('style', 'display: none');
            document.getElementById("w3").style.display = "none";
            document.getElementById("w4").style.display = "none";
            document.getElementById("w5").style.display = "none";
            document.getElementById("w6").style.display = "none";

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
?>
<style>
    #myDiv,#create-button-id,#avn_id,#w1,#w2,#w3{
        display: none;
        //text-align: center;
    }
</style>
<div class="education-form">

    <?php
    $necta = '';
    $nonenecta = '';
    $college = '';

    if ($model->is_necta == 1 && $model->is_necta != NULL) {
        $necta = "checked='checked'";
        echo '<style>
        #w1{
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
         #create-button-id,#w2,#w1{
            display:block;
        } 
    </style>';
    } else if ($model->is_necta ==3 && $model->is_necta != NULL) {
        $college = "checked='checked'";
        
        echo '<style>
      
        #create-button-id,#avn_id,#w1,#w2,#w3{
            display:block;
        } 
       .field-education-country_id,.field-education-registration_number{
            display: none;
        }
    </style>';
    }
    if ($model->under_sponsorship == 1 && $model->under_sponsorship != NULL) {
        //$nonenecta = "checked='checked'";
        echo '<style>
        .field-education-sponsor_proof_document,#w3{
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
    ?>

    <center>  
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('NECTA')" value="1" <?php echo $necta; ?> >NECTA [Completed in Tanzania]</label>
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('NONE-NECTA')" value="2" <?php echo $nonenecta; ?> >NON-NECTA [Holder of Foreign Certificate]</label>
        <label class="radio-inline"><input type="radio" name="Education[is_necta]" onclick="setType('COLLEGE')" value="3" <?php echo $college; ?> >NACTE</label>
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
        'browseLabel' => 'Attach Sponsorship Proof Document',
        'initialPreview' => [
            "$model->sponsor_proof_document",
        ],
        'initialCaption' => sponsor_proof_document,
        'initialPreviewAsData' => true,
        'initialPreviewConfig' => [
            ['type'=> "pdf"],
        ],
    ]
]);
?>
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