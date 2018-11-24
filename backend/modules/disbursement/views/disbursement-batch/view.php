<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementBatch */

$this->title ="View Disbursement Batch";
$this->params['breadcrumbs'][] = ['label' => 'Disbursement Batch', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-batch-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">
    <p>
         <?php
       
         if($model->is_approved==0){ ?>
        <?php //= Html::a('Update', ['update', 'id' => $model->disbursement_batch_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->disbursement_batch_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
       <?= Html::a('Submit', ['officersubmit', 'id' => $model->disbursement_batch_id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Are you sure you want to Submit this Disbursement?',
                'method' => 'post',
            ],
        ]) ?>
        <?php
         }
         ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => true,
        'hover' => true,
        'attributes' => [
           // 'disbursement_batch_id',
           // 'learningInstitution.institution_name',
            //'learning_institution_id',
            //'academicYear.academic_year',
            //'allocationBatch.batch_number',
            //'batch_number',
            'batch_desc',
            'instalment_type',
           // 'is_approved',
            'approval_comment:ntext',
            'institution_payment_request_id',
            'payment_voucher_number',
            'cheque_number',
           // 'created_at',
           // 'created_by',
        ],
    ]) ?>

</div>
 </div>
</div>