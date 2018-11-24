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
  $("#resetId").click(function() {
      alert("cleaning");
             $(this).closest("form").find("input[type=text], textarea").val("");
});
 $('#reset-form').on('click', function()
    { 
          alert("nucju");
    });
    function check_reset(){
        //alert("mickidadi");
    }
</script>
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var frontend\modules\application\models\Education $model
 * @var yii\widgets\ActiveForm $form
 */
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
          
?>

<div class="education-form">

    <?php
                        $yearmax=date("Y");
        for($y=1988;$y<=$yearmax;$y++){
                        $year[$y]=$y;    
        }
      $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_VERTICAL,
                 
                 'options' => ['enctype' => 'multipart/form-data','id'=>'myformId'],
                
                'enableClientValidation' => TRUE,
    ]);
   echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
              'institution_name' => ['label'=>'Primary School Name', 'type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter School Name...', 'maxlength' => 50]],
        ]
    ]);
       if(!$model->isNewRecord&&$model->learningInstitution->ward_id>0){
       $modelz=  \backend\modules\disbursement\models\Ward::findOne($model->learningInstitution->ward_id);
         
       @$model->district_id=$modelz->district_id;
       ################find region Id ##############
        @$model->ward_id=$model->learningInstitution->ward_id;
        $modelr= \common\models\District::findOne($modelz->district_id);
        @$model->region_id=$modelr->region_id;
         }
     
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
               'entry_year' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Enty Year',
                'options' => [
                    'data' => $year,
                    'options' => [
                        'prompt' => 'Select Entry Year',
                        //'onchange' => 'check_reset()',
                       // 'id'=>'entry_year_id'
                    
                    ],
                ],
            ],
   
    'completion_year' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Completion Year',
                'options' => [
                    'data' => $year,
                    'options' => [
                        'prompt' => 'Select Completion Year',
                        'onchange' => 'check_reset()',
                        //'id'=>'entry_year_id'
                    
                    ],
                ],
            ],
                  'region_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Region',
                       
                'options' => [
                    'data' => ArrayHelper::map(\common\models\Region::find()->all(), 'region_id', 'region_name'),
                    'options' => [
                        'prompt' => 'Select Region Name',
                         'onchange' => 'check_reset()',
                       // 'id'=>'region_Id'
                    ],
                ],
            ],
    'district_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District',
               'widgetClass' => DepDrop::className(),
                'options' => [
                    'data' =>  ArrayHelper::map(\common\models\District::find()->all(), 'district_id', 'district_name'),
                      'options' => [
                        'prompt' => 'Select District Name',
                       // 'id'=>'district_id',
                        
                    ],
                    'pluginOptions' => [
                        'depends' => ['education-region_id'],
                        'allowClear'=>true,
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
                        'depends' => ['education-district_id'],
                        'placeholder' => 'Select ',
                        'url' => Url::to(['/application/district/ward-name']),
                    ],
                ],
            ],
    'under_sponsorship' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Were you sponsored ?',
                'options' => [
                    'data' =>[1=>"YES",2=>"NO"],
                    'options' => [
                        'prompt' => 'Select',
                        'onchange' => 'check_sponsorship()',
                        //'id'=>'entry_year_id'
                    
                    ],
                ],
            ],
            // 'entry_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Entry Year...']],
           //  'completion_year' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Completion Year...']],
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
        'browseLabel' =>  'Attach Sponsorship Proof Document',
             'initialPreview'=>[
            "$model->sponsor_proof_document",
           
        ],
        'initialCaption'=>$model->sponsor_proof_document,
        'initialPreviewAsData'=>true,
        'initialPreviewConfig' => [
            ['type'=> "pdf"],
        ],
         
    ]
]);
     
      
?>
 <?= $form->field($model, 'level')->label(false)->hiddenInput(['value'=>'PRIMARY']) ?>

            <div class="text-right">

            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

           <?php
            echo Html::Button('Reset', ['class' => 'btn btn-default','id'=>'reset-form','onclick' => '(function ( $event ) {  $("#myformId")[0].reset(); })();$("select").val("").trigger("change");']);
            ?>
            <?= Html::a('Cancel', ['primary-view'], ['class' => 'btn btn-warning']) ?>
<?php
ActiveForm::end();
?>
