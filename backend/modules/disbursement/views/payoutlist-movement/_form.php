<?php
/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovement */
/* @var $form yii\widgets\ActiveForm */
 $tzsql= Yii::$app->db->createCommand("SELECT SUM(disbursed_amount) as amount FROM `disbursement` di WHERE di.disbursement_batch_id='{$disbursementId}'")->queryAll();           
   // $modelamount=  \backend\modules\disbursement\models\Disbursement::find()->select('SUM(disbursed_amount)')->where(['disbursement_batch_id'=>$disbursementId])->all(); 
  //  print_r($tzsql);
     $amountlimit=0;
     //echo $disbursementId;
     //echo $sqlall="SELECT group_concat(du.`disbursement_structure_id`) as groupdata FROM `disbursement_task_assignment` dt,disbursement_task_definition dd,disbursement_schedule ds , disbursement_user_structure du WHERE dd.disbursement_task_id=dt.`disbursement_task_id` AND ds.disbursement_schedule_id=dt.`disbursement_schedule_id` AND du.`disbursement_structure_id`=dt.`disbursement_structure_id` AND operator_name='Between' AND from_amount<'{$amountlimit}' AND to_amount<='{$amountlimit}'";
      
    foreach($tzsql as $tzrow);
       $amountlimit=$tzrow["amount"];
        $sqlall="SELECT Max(du.`disbursement_structure_id`) as maxlevel FROM `disbursement_task_assignment` dt,disbursement_task_definition dd,disbursement_schedule ds , disbursement_user_structure du WHERE dd.disbursement_task_id=dt.`disbursement_task_id` AND ds.disbursement_schedule_id=dt.`disbursement_schedule_id` AND du.`disbursement_structure_id`=dt.`disbursement_structure_id` AND operator_name='Between' AND from_amount<'{$amountlimit}' AND to_amount<='{$amountlimit}'";
       $modelp= Yii::$app->db->createCommand($sqlall)->queryAll();         
       foreach ($modelp as $rows);
        $structureId=$rows["maxlevel"];
    //SELECT * FROM `disbursement_task_assignment` dt,disbursement_task_definition dd,disbursement_schedule ds , disbursement_user_structure du WHERE dd.disbursement_task_id=dt.`disbursement_task_id` AND ds.disbursement_schedule_id=dt.`disbursement_schedule_id` AND du.`disbursement_structure_id`=dt.disbursement_structure_id
     $sqlmax="SELECT group_concat(user_id) as listuser FROM disbursement_user_structure WHERE disbursement_structure_id='{$structureId}'";
      $modelmax= Yii::$app->db->createCommand($sqlmax)->queryAll();  
    foreach($modelmax as $rowmax);
      $alluserId=$rowmax["listuser"];
       ?>
 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
 
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
 
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
        //''=>['label'=>'Item Name', 'options'=>['placeholder'=>'Item Name...']],
    'to_officer' => ['type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\select2\Select2::className(),
                'label' => 'Officer Name',
                'options' => [
                    'data' => ArrayHelper::map(\common\models\User::find()->where("login_type=5 AND  user_id IN($alluserId)")->all(), 'user_id', 'firstname'),
                    'options' => [
                        'prompt' => 'Select Disbursement Structure',
                        
                    
                    ],
                ],
            ],
  'comment' => ['type' => Form::INPUT_TEXTAREA,
                 'label' => 'Comment',
                
      ]
    ]
]);
 
?>
 
  <div class="text-right">
    <?= $form->field($model, 'date_out')->label(false)->hiddenInput(["value"=>date("Y-m-d")]) ?>
     <?= $form->field($model, 'disbursements_batch_id')->label(false)->hiddenInput(["value"=>$disbursementId]) ?>
    <?= $form->field($model, 'from_officer')->label(false)->hiddenInput(['value'=>\yii::$app->user->identity->user_id]) ?>
  
 <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  
<?php
echo Html::resetButton('Reset', ['class'=>'btn btn-default']);
?>
  <?php //= Html::a('Cancel', ['index','id'=>$model->isNewRecord ?$disbursement_schedule_id:$model->disbursement_schedule_id], ['class' => 'btn btn-primary']) ?>
              
      <?php
ActiveForm::end();
?>
 
    </div>
