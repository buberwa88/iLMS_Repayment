<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

$this->title = "LOAN DISBURSEMENT SCHEDULES SUMMARY";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'List Review Disbursement'), 'url' => ['/disbursement/disbursement-batch/reviewall-disbursement']];
$this->params['breadcrumbs'][] = $this->title;
//find loan item of the disbursement batch
//echo "SELECT group_concat(`item_name`) as `item_name` FROM `disbursement` d join  `loan_item` l on d.`loan_item_id`=l.`loan_item_id` WHERE disbursement_batch_id='{$model->disbursement_batch_id}' group by l.loan_item_id";
$sqlitem=Yii::$app->db->createCommand("SELECT  `item_name` FROM `disbursement` d join  `loan_item` l on d.`loan_item_id`=l.`loan_item_id` WHERE disbursement_batch_id='{$model->disbursement_batch_id}' group by l.loan_item_id,disbursement_batch_id")->queryAll();
$items=""; 
if(count($sqlitem)>0){
foreach ($sqlitem as $rowitem){
$items.=$rowitem["item_name"]." ;";
}
  }
//end
  $modelinst=  \backend\modules\allocation\models\base\LearningInstitution::findOne($model->learning_institution_id)
?>
<div class="allocation-batch-view">
    <div class="panel panel-info">
        <div class="panel-heading">
            <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">


            <table id="example2" class="table table-bordered table-hover">
                <thead>

                    <tr>
                        <th colspan="3">To</th>
                        <th>Director of Finance and Administration</th>
                    </tr>
                    <tr>
                        <th colspan="3">Date</th>
                        <td><?= date("Y-m-d") ?></td>
                    </tr>
                    <tr>
                        <th colspan="3">Institution</th>
                        <td><?= $modelinst->institution_code ?></td>
                    </tr>
                    <tr>
                        <th colspan="3">Header Id</th>
                        <td><?= $model->disbursement_batch_id ?></td>
                    </tr>
                    <tr>
                        <th colspan="3">Loan Item</th>
                        <td><?= $items ?></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>YOS</th>
                        <th>NUMBER OF STUDENTS</th>
                        <th align='right'>AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // print_r($dataProvider);
                    $tzsql = Yii::$app->db->createCommand("SELECT *,SUM(disbursed_amount) as amount,count(*) as counts FROM `disbursement` di,application ap,disbursement_batch dis WHERE di.`application_id`=ap.`application_id` AND di.`disbursement_batch_id`=dis.disbursement_batch_id AND dis.disbursement_batch_id='{$model->disbursement_batch_id}' group by `current_study_year`,`instalment_definition_id`")->queryAll();

                    $total = 0;
                    $i = 1;
                    if (count($tzsql) > 0) {
                        foreach ($tzsql as $rows) {
                            echo "<tr>
                        <td>" . $i . "</td>
                        <td>" . $rows["current_study_year"] . "</td>
                         <td>" . $rows["counts"] . "</td>
                        <td align='right'>" . number_format($rows["amount"]) . "</td>
                     
                      </tr>";
                            $total+=$rows["amount"];
                            $i++;
                        }
                        echo "<tr>
                        <td colspan='3'> </td>
                        <td align='right'><b>" . number_format($total) . "</b></td>
                      </tr>";
                    } else {
                        echo "<tr><td colspan='2'><font color='red'>Sorry No results found</font></td></tr>";
                    }
                    ?>

                </tbody>

            </table>
            <p class="pull-right">
                <?php //= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->allocation_batch_id], ['class' => 'btn btn-primary'])  ?>
                <?php
                //find the user 
                  $userId = Yii::$app->user->identity->user_id;
                $modeldata = \backend\modules\disbursement\models\base\DisbursementUserStructure::find()->select("disbursement_structure_id")->where(["user_id" => $userId])->asArray()->all();
                $comparearray = array();
                $sqldata = '';
                $checkcount = count($modeldata);
                foreach ($modeldata as $modeldatas => $values) {
                    $comparearray[] = $values["disbursement_structure_id"];
                    $sqldata.=$values["disbursement_structure_id"] . ',';
                }
                
              
                $sqlall = "SELECT * FROM `disbursement_task_assignment` dt,disbursement_task_definition dd,disbursement_schedule ds , disbursement_user_structure du,`disbursement_structure` dst WHERE dd.disbursement_task_id=dt.`disbursement_task_id` AND ds.disbursement_schedule_id=dt.`disbursement_schedule_id` AND du.`disbursement_structure_id`=dt.`disbursement_structure_id` AND du.`disbursement_structure_id`=dst.`disbursement_structure_id` AND user_id='{$userId}'";
                $modelp = Yii::$app->db->createCommand($sqlall)->queryAll();
                   if(count($modelp)>0){
                foreach ($modelp as $rows) {
                   
                    if ($rows["operator_name"] == 'Between' && $total > 0&&$rows["from_amount"] <= $total && $total <= $rows["to_amount"]) {
                      //  $innercheck = \backend\modules\disbursement\models\PayoutlistMovement::findOne(['movement_status' => 0, 'to_officer' => $userId, 'disbursements_batch_id'=>$model->disbursement_batch_id]);
                      //inner check 
                        
                    //   echo "SELECT * FROM `disbursement_payoutlist_movement`,`disbursement_user_structure`  WHERE `to_officer`=`disbursement_user_structure_id` AND movement_status=0 AND user_id='{$userId}' AND disbursements_batch_id='{$model->disbursement_batch_id}'";
                     $innercheck=Yii::$app->db->createCommand("SELECT * FROM `disbursement_payoutlist_movement` WHERE  movement_status=0 AND to_officer='{$userId}' AND disbursements_batch_id='{$model->disbursement_batch_id}'")->queryAll();
                        if (count($innercheck) > 0) {
                            ?>     
                          <?= Html::a($rows["code"], ['review-decision', 'id' => $model->disbursement_batch_id, 'level' => $rows["order_level"]], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => 'Are you sure you want to Verify this Disbursement?',
                                    'method' => 'post',
                                ],
                            ])
                            ?>
                          <?php
                             } else {
                            ?>
                            <?= Html::button($rows["code"] . '(Disabled)', ['value' => "", 'title' => '', 'disabled' => 'disabled', 'class' => 'btn btn-success']); ?>

                        <?php } ?>
                        <?php
                    } elseif ($rows["operator_name"] == 'Greater than' && $total > 0 && $rows["from_amount"] <= $total) {
                        ?>
                        <?php
                      ///  echo "SELECT * FROM `disbursement_payoutlist_movement`,`disbursement_user_structure`  WHERE `to_officer`=`disbursement_user_structure_id` AND movement_status=0 AND to_officer='{$userId}' AND disbursements_batch_id='{$model->disbursement_batch_id}'";
                   $innercheck=Yii::$app->db->createCommand("SELECT * FROM `disbursement_payoutlist_movement` WHERE  movement_status=0 AND to_officer='{$userId}' AND disbursements_batch_id='{$model->disbursement_batch_id}'")->queryAll();
                   //print_r($innercheck);
                 //  echo "mickidadi";
                        if (count($innercheck) > 0) {
                            ?>  
                            <?=
                            Html::a($rows["code"], ['review-decision', 'id' => $model->disbursement_batch_id, 'level' => $rows["order_level"]], [
                                'class' => 'btn btn-success',
                                'data' => [
                                    'confirm' => 'Are you sure you want to Verify this Disbursement?',
                                    'method' => 'post',
                                ],
                            ])
                            ?>         

                            <?php
                        } else {
                            ?>
                            <?= Html::button($rows["code"] . '(Disabled)', ['value' => "", 'title' => '', 'disabled' => 'disabled', 'class' => 'btn btn-success']); ?>

                            <?php
                        }
                    }
                }
              }  else {
              //echo "Mickidadi empty";    
             }
                ?>
            </p>
        </div>
    </div>
</div>