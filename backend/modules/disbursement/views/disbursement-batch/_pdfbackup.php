<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

$this->title ="LOAN DISBURSEMENT SCHEDULES SUMMARY";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batches'), 'url' => ['/disbursement/default/allocation-batch']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-view">
  <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
        <?php //= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->allocation_batch_id], ['class' => 'btn btn-primary']) ?>
        <?php /*= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->allocation_batch_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) */?>
    </p>
  
    <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th colspan="4">LOAN DISBURSEMENT SCHEDULES SUMMARY</th>
                      </tr>
                         <tr>
                       <th colspan="3">To</th>
                        <th>Director of Finance and Administration</th>
                      </tr>
                       <tr>
                       <th colspan="3">Date</th>
                        <th><?=date("Y-m-d")?></th>
                      </tr>
                        <tr>
                     <th colspan="3">Institution</th>
                        <th><?=$model->disbursement_batch_id?></th>
                      </tr>
                         <tr>
                     <th colspan="3">Header Id</th>
                        <th><?=$model->disbursement_batch_id?></th>
                      </tr>
                           <tr>
                        <th colspan="3">Loan Item</th>
                        <th><?=$model->disbursement_batch_id?></th>
                      </tr>
                      <tr>
                        <th>#</th>
                        <th>YOS</th>
                        <th>NUMBER OF STUDENTS</th>
                        <th>AMOUNT</th>
                      </tr>
                    </thead>
                    <tbody>
                       
                   
                        <?php
                       // print_r($dataProvider);
   $tzsql= Yii::$app->db->createCommand("SELECT *,SUM(disbursed_amount) as amount,count(*) as counts FROM `disbursement` di,application ap,disbursement_batch dis WHERE di.`application_id`=ap.`application_id` AND di.`disbursement_batch_id`=dis.disbursement_batch_id group by `current_study_year`,`instalment_definition_id`")->queryAll();           
                           
                        $total=0;
                        $i=1;
                 if(count($tzsql)>0){
                 foreach ($tzsql as $rows){
                 echo "<tr>
                        <td>".$i."</td>
                        <td>".$rows["current_study_year"]."</td>
                         <td>".$rows["counts"]."</td>
                        <td align='right'>".number_format($rows["amount"])."</td>
                     
                      </tr>";
                 $total+=$rows["amount"];
                 $i++;
                           }
               echo "<tr>
                        <td colspan='3'> </td>
                        <td align='right'><b>".number_format($total)."</b></td>
                     
                      </tr>";
                  }
                  else{
               echo "<tr><td colspan='2'><font color='red'>Sorry No results found</font></td></tr>";       
                  }
                       ?>
                  
                    </tbody>
                    
                  </table>
</div>
  </div>
</div>