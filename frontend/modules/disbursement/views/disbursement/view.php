<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $model backend\modules\disbursement\models\DisbursementBatch */

$this->title ="Disbursement Detail";
$this->params['breadcrumbs'][] = ['label' => 'Disbursement', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disbursement-batch-view">
 <div class="panel panel-info">
        <div class="panel-heading">
       <?= Html::encode($this->title) ?>
        </div>
        <div class="panel-body">


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
//           // 'is_approved',
//            'approval_comment:ntext',
//            'institution_payment_request_id',
//            'payment_voucher_number',
//            'cheque_number',
            'created_at',
           // 'created_by',
        ],
    ]) ?>

</div>
 </div>
</div>