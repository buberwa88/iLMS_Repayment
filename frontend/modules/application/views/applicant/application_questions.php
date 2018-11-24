<script>
 
 function TriggerQn(question_id){
    var ans = $('#control_id_'+question_id).val();
   
   
    $.ajax({
        url: '<?= yii\helpers\Url::to(['/application/applicant/trigger-qn'], true) ?>&question_id='+question_id+'&ans='+ans,
        type: 'get',
        dataType: 'JSON',
        success: function(response){
          var res =  response.controls;
          
          if(response.pquestion_id != ''){
              $( "div" ).remove( "#div_"+response.pquestion_id );
          }
          $(res).insertAfter( "#div_"+question_id );
        }
    });   
 }
    
</script>

<?php
use yii\helpers\Html;
$this->title = "Questions";
$this->params['breadcrumbs'][] = ['label' => 'Parent View', 'url' => ['applicant-associate/parent-view']];
$this->params['breadcrumbs'][] = $this->title;

?>
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
  <?php
echo '<form name = "form_qns" method = "POST" enctype = "multipart/form-data">';
$qns = Yii::$app->db->createCommand("select * from question  q join section_question sq on q.`question_id`=sq.`question_id` where applicant_category_section_id=9 AND q.question_id NOT IN (select question_id from qns_to_trigger)")->queryAll();
foreach ($qns as $key => $value) {
    $triggered_qn = false;
    getControl($value);
    $pans = \Yii::$app->db->createCommand("select  qtrigger_main.qtrigger_main_id, qpossible_response.qpossible_response_id, qns_to_trigger.question_id  from qtrigger inner join qpossible_response on qpossible_response.qpossible_response_id = qtrigger.qpossible_response_id inner join qtrigger_main on qtrigger_main.qtrigger_main_id=qtrigger.qtrigger_main_id inner join qns_to_trigger on qns_to_trigger.qtrigger_main_id = qtrigger_main.qtrigger_main_id where qpossible_response.question_id={$value['question_id']} ")->queryOne();
    if($pans !== false){
    $triggered_qn = \Yii::$app->db->createCommand("select question.*  from qns_to_trigger inner join qtrigger_main on qtrigger_main.qtrigger_main_id = qns_to_trigger.qtrigger_main_id inner join qtrigger on qtrigger.qtrigger_main_id = qtrigger_main.qtrigger_main_id inner join qpossible_response on qpossible_response.qpossible_response_id = qtrigger.qpossible_response_id 
inner join question on question.question_id = qns_to_trigger.question_id 
inner join applicant_question on applicant_question.question_id=question.question_id
where qpossible_response.question_id = {$value['question_id']} AND applicant_question.application_id = {$application_id}")->queryOne();
    }
    
    if($triggered_qn !== false){
      
       getControl($triggered_qn); 
    } 
}
echo '<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />';
echo '<input type="submit" value="Submit" />';
echo '</form>';
?>

        </div>
    </div>
<?php
function getAnswer($question_id){
   $ans = Yii::$app->db->createCommand("select applicant_qn_response.response_id, applicant_qn_response.question_answer, question.response_control from applicant_qn_response inner join applicant_question on applicant_question.applicant_question_id=applicant_qn_response.applicant_question_id inner join question on question.question_id = applicant_question.question_id where question.question_id = {$question_id}")->queryAll(); 
   foreach ($ans as $key => $value) {
      $ans_checkbox = array();
      if($value['response_control'] == 'CHECKBOX'){
          $ans_checkbox[] = $value['response_id'];
      } elseif($value['response_control'] == 'TEXTBOX'){
          return $value['question_answer'];
      } else{
          return $value['response_id'];
      }
   }
   
   return $ans_checkbox;
}

function getControl($value){
        switch ($value['response_control']) {
        case 'TEXTBOX':
            echo "<div id = 'div_{$value['question_id']}'>";
            echo "<label>{$value['question']}</label> <br>";
            echo '<input type="text" name="control_name_'.$value['question_id'].'" value="'. getAnswer($value['question_id']).'" /> <br><br>';
            echo '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            echo "</div>";
            break;
        case 'DROPDOWN':
            echo "<div id = 'div_{$value['question_id']}'>";
            echo "<label>{$value['question']}</label> <br>";
            $pres = Yii::$app->db->createCommand("select qpossible_response.qpossible_response_id as qpossible_response_id, qresponse_list.response as response,qresponse_list.qresponse_list_id AS qresponse_list_id from qpossible_response inner join qresponse_list on qresponse_list.qresponse_list_id = qpossible_response.qresponse_list_id where qpossible_response.question_id = {$value['question_id']}")->queryAll();
            $ans = array();
            $ans['empty']= '';
            foreach ($pres as $v) {
               $ans[$v['qresponse_list_id']] = $v['response'];
            }
            echo yii\helpers\Html::dropDownList('control_name_'.$value['question_id'], getAnswer($value['question_id']), $ans,['onchange'=>"TriggerQn({$value['question_id']})","id"=>"control_id_{$value['question_id']}"])."<br><br>";
            echo '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            echo "</div>";
            break;
        case 'CHECKBOX':
            echo "<div id = 'div_{$value['question_id']}'>";
            echo "<label>{$value['question']}</label> <br>";
            $pres = Yii::$app->db->createCommand("select qpossible_response.qpossible_response_id as qpossible_response_id, qresponse_list.response as response from qpossible_response inner join qresponse_list on qresponse_list.qresponse_list_id = qpossible_response.qresponse_list_id where qpossible_response.question_id = {$value['question_id']}")->queryAll();
            $ans = array();
            foreach ($pres as $v) {
               $ans[$v['qresponse_list_id']] = $v['response'];
            }
            echo yii\helpers\Html::checkboxList('control_name_'.$value['question_id'], getAnswer($value['question_id']), $ans)."<br><br>";
            echo '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            echo "</div>";
            break;
        case 'FILE':
            echo "<div id = 'div_{$value['question_id']}'>";
            echo "<label>{$value['question']}</label> <br>";
            echo '<input type = "file" name = "control_name_'.$value['question_id'].'" value = "" /> <br><br>'; 
            echo '<input type="hidden" name="question_id[]" value="'.$value['question_id'].'" />';
            echo "</div>";
            break;
            
        default:
            break;
    }
}