<script>
      document.getElementById("loader").style.display = "none";
    function setType(type) {
        $('#create-button-id').attr('style', 'display: block');
        if (type == 'NECTA') {
            //Show
             $('#switch_right').val('1');
              $("#education-registration_number").attr('maxlength','10');
            $('#w2').attr('style', 'display: block');
            //Hide
            $('#w1').attr('style', 'display: none');
            $('#w3').attr('style', 'display: none');
            
        }

        if (type == 'NONE-NECTA') {
            //Show
            $("#education-registration_number").attr('maxlength','16');
            $('#switch_right').val('2');
            $('#w1').attr('style', 'display: block');
            $('#w3').attr('style', 'display: block');
            $('#w2').attr('style', 'display: block');
            //Hide
            

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
        #w1, #w3{
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
        #w1, #w2, #w3, #create-button-id{
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
   echo $form->field($model, 'sponsor_proof_document')->widget(FileInput::classname(), [
        
       'options' => ['accept' => 'image/*'],
        'pluginOptions' => [
         'initialPreviewShowDelete' => true,
         'showCaption' => false,
        //'showRemove' => TRUE,
        'showUpload' => false,
        //'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="fa fa fa-file-pdf-o"></i> ',
        'browseLabel' =>  'Attach sponsorship Proof Document',
             'initialPreview'=>[
            "$model->sponsor_proof_document",
           
        ],
      'initialPreviewConfig' => [
            ['type'=> "pdf"],
        ],
        'initialCaption'=>sponsor_proof_document,
        'initialPreviewAsData'=>true,
         
    ]
]);
?>
            <div class="text-right">

            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>

            <?php
            echo Html::resetButton('Reset', ['class' => 'btn btn-default']);
            ?>
            <?= Html::a('Cancel', ['olevel-view'], ['class' => 'btn btn-warning']) ?>
<?php
ActiveForm::end();
//print_r($model->errors);
?>