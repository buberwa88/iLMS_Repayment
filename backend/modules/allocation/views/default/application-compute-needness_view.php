<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\application\models\Application */

?>
<div class="application-view">
  <?= DetailView::widget([
        'model' => $model,
          'condensed' => true,
        'hover' => true,
        'attributes' => [
            
            'application_id',
             //'applicant_category_id',
            //'applicant_id',
           // 'academic_year_id',
            //'bill_number',
           // 'control_number',
           // 'receipt_number',
           // 'amount_paid',
            //'pay_phone_number',
            //'date_bill_generated',
          //  'date_control_received',
          //  'date_receipt_received',
           // 'programme_id',
                   [
        'attribute'=>'programme_id', 
        'label'=>'programme',
        'format'=>'raw',
        'value'=>call_user_func(function ($data){
            return $data->programme->programme_name;
        },$model),
       // 'valueColOptions'=>['style'=>'width:30%']
       ],
            'application_study_year',
            'current_study_year',
           // 'bank_account_number',
         //   'bank_account_name',
         //   'bank_id',
          //  'bank_branch_name',
           // 'submitted',
            'verification_status',
            'myfactor',
            'ability',
            'needness',
           /// 'allocation_status',
                    [
        'attribute'=>'allocation_status', 
        'label'=>'Allocation Status?',
        'format'=>'raw',
        'value'=>call_user_func(function ($data){
                           if($data->allocation_status==1){
                               $status="Elligible"; 
                            }
                           else if($data->allocation_status==2){
                             $status="Not Elligible";    
                           }
                          else if($data->allocation_status==3){
                             $status="Allocated";    
                           }
                          else if($data->allocation_status==4){
                            $status="Not allocated";     
                           }
                           else{
                               $status="Waiting";
                           }
                           return $status;
        },$model),
       // 'valueColOptions'=>['style'=>'width:30%']
    ], 'allocation_comment',
                    [
        'attribute'=>'student_status', 
        'label'=>'Student Status?',
        'format'=>'raw',
        'value'=>$model->student_status ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>',
        // 'valueColOptions'=>['style'=>'width:30%']
    ],
            'created_at',
       
        ],
    ]) ?>

</div>
