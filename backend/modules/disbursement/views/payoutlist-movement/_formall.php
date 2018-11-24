<?php
 
/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\PayoutlistMovement */
/* @var $form yii\widgets\ActiveForm */
$tzsql = Yii::$app->db->createCommand("SELECT SUM(disbursed_amount) as amount FROM `disbursement` WHERE disbursement_batch_id='{$disbursementId}'")->queryAll();
 /*
  * what is the level of the login user ?
  */

/*
 * end find the level
 */
$amountlimit = 0;
$alluserId="";
foreach ($tzsql as $tzrow);
$amountlimit = $tzrow["amount"];
 $sqlall = "SELECT order_level as maxlevel,disbursement_structure_id FROM disbursement_schedule_view WHERE operator_name='Between' AND from_amount>'{$amountlimit}' AND to_amount<='{$amountlimit}' AND order_level<'{$level}' order by order_level DESC limit 1";
$modelp = Yii::$app->db->createCommand($sqlall)->queryAll();

//greate than

 if(count($modelp)==0){
    $sqlalla = "SELECT order_level as maxlevel,disbursement_structure_id FROM disbursement_schedule_view WHERE operator_name='Greater than' AND from_amount<'{$amountlimit}' AND order_level<'{$level}' order by order_level DESC limit 1";
$modelp = Yii::$app->db->createCommand($sqlalla)->queryAll();    
  }
 // exit();
//end 
  $alluserId=0;
   if(count($modelp)>0){
    foreach ($modelp as $rows);
     $structureId = $rows["disbursement_structure_id"];
    //SELECT * FROM `disbursement_task_assignment` dt,disbursement_task_definition dd,disbursement_schedule ds , disbursement_user_task du WHERE dd.disbursement_task_id=dt.`disbursement_task_id` AND ds.disbursement_schedule_id=dt.`disbursement_schedule_id` AND du.`disbursement_structure_id`=dt.disbursement_structure_id
     $sqlmax = "SELECT group_concat(user_id) as listuser FROM disbursement_user_structure WHERE disbursement_structure_id='{$structureId}' AND status=0";
    $modelmax = Yii::$app->db->createCommand($sqlmax)->queryAll();
  if(count($modelmax)>0){
        foreach ($modelmax as $rowmax);
       $alluserId = $rowmax["listuser"];
          }
}
?>
 
<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
 
$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
   if($alluserId!=0){
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
                    'data' =>ArrayHelper::map(\common\models\User::find()->where("login_type=5 AND  user_id IN($alluserId)")->all(), 'user_id', 'firstname'),
                    'options' => [
                        'prompt' => 'Select Disbursement Structure',
                        
                    
                    ],
                ],
            ],
 
    ]
]);
 }else{ ?>
 <?= $form->field($model, 'to_officer')->label(false)->hiddenInput(['value'=>\yii::$app->user->identity->user_id]) ?>
         
   <?php
   }
echo Form::widget([ // fields with labels
    'model'=>$model,
    'form'=>$form,
    'columns'=>1,
    'attributes'=>[
   
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
