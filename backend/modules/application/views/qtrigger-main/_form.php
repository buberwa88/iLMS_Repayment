<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\application\models\QtriggerMain $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="qtrigger-main-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'description' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Description...', 'maxlength' => 100]],

            'join_operator' => ['type' => Form::INPUT_DROPDOWN_LIST,  'items'=>['AND'=>'AND','OR'=>'OR'], 'options' => ['prompt' => 'NOT APPLICABLE']],

        ]

    ]);
     echo "<label>Select answers that will trigger the questions</label> <br>";
     $query = "select question.question_id,question.question, qresponse_list.response, qpossible_response.qpossible_response_id, qtrigger.qpossible_response_id as qpossible_response_id_inserted from question inner join qpossible_response on question.question_id=qpossible_response.question_id inner join qresponse_list on qresponse_list.qresponse_list_id = qpossible_response.qresponse_list_id
left join qtrigger on qtrigger.qpossible_response_id = qpossible_response.qpossible_response_id 
where qtrigger.qtrigger_main_id IS NULL OR qtrigger.qtrigger_main_id = '{$model->qtrigger_main_id}'
order by question.question_id";
     $records = Yii::$app->db->createCommand($query)->queryAll();
     foreach ($records as $key => $record) {
         
         if($record['qpossible_response_id_inserted'] == NULL || $record['qpossible_response_id_inserted'] == ''){
            $checked = ""; 
         } else {
             $checked = " checked = 'checked' ";
         }
         echo '<label><input type = "checkbox" name = "response[]" value = "'.$record['qpossible_response_id'].'" '.$checked.' /> '.$record['question'].' - '.$record['response'].'</label><br> ';
    }
     echo '<br>';
     
          echo "<label>Questions to appear when the above condition is met</label> <br>";
     $query = "select question.question_id, qns_to_trigger.question_id as question_id_inserted, question.question from question left join qns_to_trigger on qns_to_trigger.question_id = question.question_id where qns_to_trigger.qtrigger_main_id IS NULL OR qns_to_trigger.qtrigger_main_id = '{$model->qtrigger_main_id}'
order by question.question_id";
     $records = Yii::$app->db->createCommand($query)->queryAll();
     foreach ($records as $key => $record) {
         
         if($record['question_id_inserted'] == NULL || $record['question_id_inserted'] == ''){
            $checked = ""; 
         } else {
             $checked = " checked = 'checked' ";
         }
         echo '<label><input type = "checkbox" name = "questions[]" value = "'.$record['question_id'].'" '.$checked.' /> '.$record['question'].'</label><br> ';
    }
     echo '<br>';
     ?>
    <div class="text-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
 <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-warning']) ?>
   
    </div>
   <?php ActiveForm::end(); ?>
    
</div>
