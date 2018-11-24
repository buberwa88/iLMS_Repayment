<script>
    function EDSource(){
        var sl = $('#question-response_control').val();
        if(sl == 'TEXTAREA' || sl =='TEXTBOX'){
           $('#question-qresponse_source_id').attr('disabled',true); 
           $('#question-qresponse_source_id').val('');
        } else {
            $('#question-qresponse_source_id').attr('disabled',false);  
        }
        
    }
</script>

<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use backend\modules\allocation\models\QresponseSource;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\Question $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="question-form">

    <?php
    $sdisabled = false;
    if($model->response_control == 'TEXTAREA' || $model->response_control == 'TEXTBOX'){
        $sdisabled = true;
    }
    
   $flashes = Yii::$app->session->getAllFlashes();
  
   foreach ($flashes as $key => $value) {
     echo '<div class="alert alert-'.$key.'">'.$value.'</div>';  
   }
    
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'question' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Question...', 'maxlength' => 500]],
            'response_control' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=>['TEXTBOX'=>'TEXTBOX','DROPDOWN'=>'DROPDOWN','CHECKBOX'=>'CHECKBOX','TEXTAREA'=>'TEXTAREA','FILE'=>'FILE'],  'options' => ['prompt' => '', 'onclick'=>'EDSource()']],
            'qresponse_source_id' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items'=> yii\helpers\ArrayHelper::map(QresponseSource::find()->all(), 'qresponse_source_id', 'source_table'),  'options' => ['prompt' => 'NOT APPLICABLE','disabled'=>$sdisabled]],
            'response_data_type' => ['type' => Form::INPUT_DROPDOWN_LIST,'items'=>['TEXT'=>'TEXT','NUMBER'=>'NUMBER','DATE'=>'DATE'],   'options' => ['prompt' => '']],
            'response_data_length' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Response Data Length...']],
            //'qresponse_source_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Qresponse Source ID...']],
            'require_verification' => ['type' => Form::INPUT_CHECKBOX, 'options' => ['placeholder' => 'Enter Require Verification...']],
            'is_active' => ['type' => Form::INPUT_CHECKBOX, 'options' => ['placeholder' => 'Enter Is Active...']],
            'hint' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Hint...', 'maxlength' => 500]],
            'verification_prompt' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Verification Prompt...', 'maxlength' => 500]],
        ]
    ]);
 
    ?>
<div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
      <?php
ActiveForm::end();
?>
    </div>
</div>
