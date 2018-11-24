<script>
      document.getElementById("loader").style.display = "none";
//    function setType(type) {
//        $('#create-button-id').attr('style', 'display: block');
//        if (type == 'NECTA') {
//            //Show
//            $('#w2').attr('style', 'display: block');
//            //Hide
//            $('#w1').attr('style', 'display: none');
//            $('#w3').attr('style', 'display: none');
//            
//        }
//
//        if (type == 'NONE-NECTA') {
//            //Show
//            $('#w1').attr('style', 'display: block');
//            $('#w3').attr('style', 'display: block');
//            $('#w2').attr('style', 'display: block');
//            //Hide
//            
//
//        }
//    }
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
 
 
 $attributes = [
          
            [
            'group' => true,
            'label' => "O-LEVEL EDUCATION  " . $sn . ': &nbsp;&nbsp; &nbsp;&nbsp; ' .$updatelink,
            'rowOptions' => ['class' => 'info'],
            'format' => 'raw',
        ],
            
            [
                'columns' => [
                  [
                        'label' => 'O-level Index#',
                        'value' => $model->registration_number,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                     [
                        'label' => 'Completion Year',
                        'value' => $model->completion_year,
                        'labelColOptions'=>['style'=>'width:20%'],
                        'valueColOptions'=>['style'=>'width:30%'],
                    ],
                ],
               ],
                 [
                'columns' => [
                    
                    [
                        'label' =>$model->is_necta==1?'O-LEVEL SCHOOl':"NON-NECTA INSTITUTION NAME",
                        'value' =>$model->learning_institution_id!=""?$model->learningInstitution->institution_name:"",
                        'labelColOptions'=>['style'=>'width:20%'],
                         //'valueColOptions'=>['style'=>'width:40%'],
                    ],
                   
                    
                ],
            ],
        ];
    echo kartik\detail\DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'mode' => kartik\detail\DetailView::MODE_VIEW,
        'attributes' => $attributes,
    ]);
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
 
    <br>
    <?= $form->field($model, 'is_necta')->label(false)->hiddenInput(['value' =>1]) ?>
      <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
         
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
        'browseLabel' =>  'Attach Sponsorship Proof Document',
             'initialPreview'=>[
            "$model->sponsor_proof_document",
           
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
//($model->errors);
?>