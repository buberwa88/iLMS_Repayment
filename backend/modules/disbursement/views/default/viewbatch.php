<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\allocation\models\AllocationBatch */

//$this->title = $model->allocation_batch_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Allocation Batch'), 'url' => ['/disbursement/default/allocation-batch']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="allocation-batch-view">
  <div class="panel panel-info">
        <div class="panel-heading">
    ALLOCATION BATCH SUMMARY
        </div>
        <div class="panel-body">
 <?php
     //find the allocation batch status
        $teststatus=  \frontend\modules\allocation\models\AllocationBatch::findone($model->allocation_batch_id);
     //end
          if($teststatus->disburse_status==0){
     ?>
    <p>
    <?= Html::a('Click to Verify this Allocation Batch ', ['approve-status', 'id' =>$model->allocation_batch_id,"status"=>1], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to Verify this Allocation Batch ?',
                'method' => 'post',
            ],
        ]) ?>
    <?= Html::a('Click to Unverified this Allocation Batch[Allocation Batch Mismatch] ', ['approve-status', 'id' =>$model->allocation_batch_id,"status"=>2], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to Verify this Allocation Batch ?',
                'method' => 'post',
            ],
        ]);
          }
        else{
        ?>
        
      <?php
        }
        ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
         'condensed' => true,
        'hover' => true,
        'attributes' => [
            //'allocation_batch_id',
            'batch_number',
            'batch_desc',
           // 'academic_year_id',
           // 'academicYear.academic_year', 
                       [
                        'attribute'=>'academic_year_id', 
                        'label'=>'Academic Year',
                        'format'=>'raw',
                        'value'=>call_user_func(function ($data){

                                           return $data->academicYear->academic_year;
                        },$model),
                       // 'valueColOptions'=>['style'=>'width:30%']
                       ],
            'available_budget',
           // 'is_approved',
            'approval_comment:ntext',
            //'created_at',
            //'created_by',
           // 'is_canceled',
            //'cancel_comment:ntext',
        ],
    ]) ?>
  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td colspan="2"><b>ALLOCATION BATCH SUMMARY</b></td>
                      </tr>
                      <tr>
                          <td><b>LOAN ITEM</b></td>
                        <td align='right'><b>AMOUNT</b></td>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                       // print_r($dataProvider);
                              
                        $total=0;
                 $sql=  backend\modules\allocation\models\Allocation::find()->select("*,sum(allocated_amount) as amount,item_name")->joinWith("loanItem")->GroupBy("item_name")->where("allocation_batch_id=$model->allocation_batch_id")->asArray()->all();
                  if(count($sql)>0){
                 foreach ($sql as $rows){
                 echo "<tr>
                        <td>".$rows["item_name"]."</td>
                        <td align='right'>".number_format($rows["amount"])."</td>
                     
                      </tr>";
                 $total+=$rows["amount"];
                           }
               echo "<tr>
                        <td> </td>
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