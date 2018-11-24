 <script>
    function check_guardian() {//
   var status = document.getElementById('guardian-having_guardian').value;
          if(status=="NO"){
           $('#form_data_id').attr('style', 'display:block'); 
          }
          else{
         $('#form_data_id').attr('style', 'display:none'); 
          }
    }
  
  </script>
 <style>
    #form_data_id {
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
$yearmax = date("Y");
//check if t
//  echo $application_id;
  $application_ids=$model->application_id>0?$model->application_id:$application_id;
 $modelparent=  frontend\modules\application\models\ApplicantAssociate::find()->where("application_id ='{$application_ids}' AND type = 'PR' AND is_parent_alive='NO' AND guarantor_type is NULL")->count();
//print_r($modelparent);
if($modelparent==2){
     $model->having_guardian='NO'; 
 echo '<style>
       #form_data_id{
            display:block;
        }
       .field-guardian-having_guardian{
            display:none;
        }
       </style>';
   }
//he parent are alive
//end check 
for ($y = 1988; $y <= $yearmax; $y++) {
    $year[$y] = $y;
}
  if ($model->having_guardian=="NO" && $model->having_guardian != NULL) {
       //$nonenecta = "checked='checked'"; 
  echo '<style>
        #form_data_id{
            display:block;
        }
      
    </style>';
    } else {
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
                'enableClientValidation' => TRUE,
    ]);
    ?>
    <?php
echo Form::widget([
  'model' => $model,
  'form' => $form,
  'columns' => 1,

  'attributes' => [
          'having_guardian'=>[
          'type' => Form::INPUT_DROPDOWN_LIST,
           'label'=>"Is your Guardian the same as your Parent ?",
          'items' => ['YES' => 'YES', 'NO' => 'NO'],
          'options' => [
                'prompt' => 'Select  Status',
                'onchange' => 'check_guardian()',
          ],
         ]
  ]
]);
  echo "<div id='form_data_id'>";
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
            'columns' => 2,
            'id' => "mickidadi12",
            'attributes' => [
                'firstname' => ['type' => Form::INPUT_TEXT, 'label' => 'First Name', 'options' => ['placeholder' => 'Enter ']],
                'middlename' => ['type' => Form::INPUT_TEXT, 'label' => 'Middle Name', 'options' => ['placeholder' => 'Enter .']],
                  'surname' => ['type' => Form::INPUT_TEXT, 'label' => 'Last Name', 'options' => ['placeholder' => 'Enter ']],
                'sex' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' => ['M' => 'Male', 'F' => 'Female'],
                     'options' => [
                    'prompt' => 'Select Gender',
                   
                ],
                ],
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
            'phone_number' => ['type' => Form::INPUT_TEXT, 'options' => ['maxlength'=>10,'placeholder' => 'Eg 0*********','data-toggle' => 'tooltip',
            'data-placement' =>'top','title' => 'eg 0752XXXXXX or 06XXXXXXXX 10 Digits']],
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
                        'id'=>'region_Id'
                    ],
                ],
            ],
    'district_id' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'District (*)',
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
    <?= $form->field($model, 'type')->label(FALSE)->hiddenInput(["value"=>"GD"]) ?>
     <div class="text-right">
        
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
        <?= Html::a('Cancel', ['guardian-view'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
//print_r($model->errors);
?>
 
    </div>
</div>
